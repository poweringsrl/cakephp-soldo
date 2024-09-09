<?php

namespace Soldo\Webservice;

use Cake\Http\Client\Response;
use Muffin\Webservice\Model\Resource;
use Muffin\Webservice\Query;
use Muffin\Webservice\ResultSet;
use Muffin\Webservice\Webservice\Webservice;
use Soldo\Error\FailedRequestException;
use Soldo\Error\NoAdvancedCredentialsException;
use Soldo\Error\ReadQueryException;
use Soldo\Utility\Fingerprint;

class SoldoWebservice extends Webservice
{
	/**
	 * The API entry point
	 *
	 * @var string
	 */
	protected const API_ENTRY_POINT = '/business/v2';

	/**
	 * The maximum number of items per page supported by Soldo
	 * 
	 * @var int
	 * 
	 * @link https://developer.soldo.com/docs/pagination-and-sorting
	 */
	protected const MAX_ITEMS_PER_PAGE = 50;

	/**
	 * The name of the header parameter for the fingerprint
	 * 
	 * @var string
	 * 
	 * @link https://developer.soldo.com/docs/advanced-authentication
	 */
	protected const FINGERPRINT_HEADER_PARAMETER = 'X-Soldo-Fingerprint';

	/**
	 * The name of the header parameter for the fingerprint signature
	 * 
	 * @var string
	 * 
	 * @link https://developer.soldo.com/docs/advanced-authentication
	 */
	protected const FINGERPRINT_SIGNATURE_HEADER_PARAMETER = 'X-Soldo-Fingerprint-Signature';

	/**
	 * @var \Soldo\Webservice\Driver\Soldo|null
	 */
	protected $_driver;

	/**
	 * @return \Soldo\Webservice\Driver\Soldo|null
	 */
	public function getDriver()
	{
		/** @var \Soldo\Webservice\Driver\Soldo|null $driver */
		$driver = parent::getDriver();

		if ($driver) {
			$driver->authenticate();
		}

		return $driver;
	}

	public function initialize()
	{
		parent::initialize();

		$this->addNestedResource('/:id', ['id']);
	}

	protected function _executeCreateQuery(Query $query, array $options = [])
	{
		return parent::_executeCreateQuery($query, $options);
	}

	protected function _executeReadQuery(Query $query, array $options = [])
	{
		$parameters = $query->where();

		if ($query->clause('order')) {
			$order = array_filter(
				array_map(function (string $direction) {
					return strtoupper($direction);
				}, $query->clause('order')),
				function (string $direction, string $field) {
					return in_array($direction, ['ASC', 'DESC']);
				},
				ARRAY_FILTER_USE_BOTH
			);

			// Currently Soldo supports only one order clause at the same time
			if (count($order) > 1) {
				throw new ReadQueryException('There must be a maximum of one order clause at a time');
			}

			$field = array_keys($order)[0];
			$direction = $order[$field];

			$parameters['d'] = $direction;
			$parameters['props'] = $field;
		}

		$fixed_parameters = [];
		foreach ($parameters as $parameter => $value) {
			$trimmed_parameter = trim($parameter);
			if (substr_compare($trimmed_parameter, ' IN', -3) === 0) {
				$trimmed_parameter = substr($trimmed_parameter, 0, -3);
			}

			$fixed_parameters[$trimmed_parameter] = $value;
		}

		$limit = $query->clause('limit');

		// In CakePHP pages are expected to start from 1, while Soldo expect pages starting from 0
		$page = ($query->clause('page') ?? 1) - 1;

		$all = !$limit || $limit > self::MAX_ITEMS_PER_PAGE;

		$url = $this->_baseUrl();

		$primary_key = $query->endpoint()->getPrimaryKey();
		if ($primary_key && isset($fixed_parameters[$primary_key])) {
			$path = $this->nestedResource(['id' => $fixed_parameters[$primary_key]]);

			if (is_string($path)) {
				$url .= $path;
			}
		}

		$json = $all
			? $this->_getRequest($query, $url, $fixed_parameters, $all)
			: $this->_getRequest($query, $url, $fixed_parameters, $all, $page, $limit);

		$results = isset($json['results']) ? $json['results'] : [$json];

		if ($query->clause('select')) {
			$fields = $query->clause('select');

			if (is_array($fields)) {
				if (!empty(array_filter($fields))) {
					$results = array_map(function ($item) use ($fields) {
						return array_reduce(array_keys($fields), function ($acc, $new_key) use ($item, $fields) {
							$old_key = $fields[$new_key];

							if (!isset($item[$old_key])) {
								$acc[$new_key] = $old_key;
							} else {
								$acc[!is_int($new_key) ? $new_key : $old_key] = $item[$old_key];
							}

							return $acc;
						}, []);
					}, $results);
				}
			}
		}

		$resources = $this->_transformResults($query->endpoint(), $results);
		$resources = is_array($resources) ? $resources : [$resources];
		$resources = $all ? $this->_paginateResults($query, $resources) : $resources;

		return new ResultSet($resources, count($resources));
	}

	protected function _executeUpdateQuery(Query $query, array $options = [])
	{
		return parent::_executeUpdateQuery($query, $options);
	}

	protected function _executeDeleteQuery(Query $query, array $options = [])
	{
		return parent::_executeDeleteQuery($query, $options);
	}

	/**
	 * Returns the base URL to use
	 * 
	 * @return string
	 */
	protected function _baseUrl()
	{
		return '/' . trim(static::API_ENTRY_POINT, '/') . '/' . $this->getEndpoint();
	}

	/**
	 * Executes a GET request based on the given parameters
	 * 
	 * @param Query $query The query to execute.
	 * @param string $url The URL to request.
	 * @param array $parameters The GET parameters to send.
	 * @param bool $all Whether to retrieve all the items or not. The way this
	 * is achieved is by continuing to make requests until the pages are
	 * finished. In this case the `$page` and `$limit` parameters are not
	 * needed.
	 * @param int $page The page to retrieve, starting from 0. Not needed in
	 * case the `$all` option is `true`.
	 * @param int $limit The number of items to retrieve. Not needed in case the
	 * `$all` option is `true`.
	 * @param array $prev_json The previous result to merge with the current
	 * result. This is used starting from the second request when the `$all`
	 * option is `true`.
	 * 
	 * @return array The response body.
	 */
	protected function _getRequest(
		Query $query,
		string $url,
		array $parameters,
		bool $all = false,
		int $page = 0,
		int $limit = self::MAX_ITEMS_PER_PAGE,
		array $prev_json = []
	) {
		$parameters['p'] = $page;
		$parameters['s'] = $limit;

		$headers = $this->_getHeaders($query, $parameters);
		$url_query = $this->_buildQuery($parameters);

		$url_no_params = $url;
		$url = empty($query) ? $url : $url . '?' . $url_query;

		$response = $this->getDriver()
			->getClient()
			->get($url, [], $headers ? ['headers' => $headers] : []);

		$json = $this->_parseResponse($response);

		if (isset($json['results'])) {
			if ($all && count($json['results']) === self::MAX_ITEMS_PER_PAGE) {
				$json = $this->_getRequest($query, $url_no_params, $parameters, $all, ++$page, $limit, $json);
			}

			$json['results'] = array_merge($prev_json['results'] ?? [], $json['results']);
		}

		return $json;
	}

	/**
	 * Executes a PUT request based on the given parameters
	 * 
	 * @param Query $query The query to execute.
	 * @param string $url The URL to request.
	 * @param array $parameters The data to send.
	 * 
	 * @return array The response body.
	 */
	protected function _putRequest(Query $query, string $url, array $parameters)
	{
		$headers = $this->_getHeaders($query, $parameters);

		$response = $this->getDriver()
			->getClient()
			->put($url, $parameters, $headers ? ['headers' => $headers] : []);

		$json = $this->_parseResponse($response);

		return $json;
	}

	/**
	 * Returns the needed HTTP headers required for the given query
	 * 
	 * @param Query $query The query.
	 * @param array $fingerprint_parameters The parameters from which to take
	 * the values if the fingerprint order requires them.
	 * 
	 * @return string[]
	 */
	private function _getHeaders(Query $query, array $fingerprint_parameters)
	{
		$endpoint_class = 'Soldo\Model\Endpoint\\' . $query->endpoint()->getAlias() . 'Endpoint';

		/** @var \Soldo\Model\SoldoEndpoint $endpoint */
		$endpoint = new $endpoint_class;
		// $endpoint = $query->endpoint();

		$headers = [];
		if ($endpoint->needsFingerprint()) {
			$token = $this->getDriver()->getConfig('token');
			$base64_private_key = $this->getDriver()->getConfig('private_key');

			if (empty($token) || empty($base64_private_key)) {
				throw new NoAdvancedCredentialsException();
			}

			$private_key = base64_decode($base64_private_key);

			$fingerprint = Fingerprint::generate($endpoint->getFingerprintOrder(), $fingerprint_parameters, $token);
			$fingerprint_signature = Fingerprint::sign($fingerprint, $private_key);

			$headers = [
				self::FINGERPRINT_HEADER_PARAMETER => $fingerprint,
				self::FINGERPRINT_SIGNATURE_HEADER_PARAMETER => $fingerprint_signature,
			];
		}

		return $headers;
	}

	/**
	 * Constructs a query string from an array of parameters
	 *
	 * This method is necessary because the built-in PHP function
	 * `http_build_query` and the HTTP client used in this plugin both
	 * concatenate "[]" to parameter names when the value is an array. However,
	 * the Soldo API does not accept square brackets for parameters that have an
	 * array as a value.
	 * 
	 * @param array $parameters
	 * 
	 * @return string A URL-encoded query string without square brackets for
	 * array parameters.
	 */
	private function _buildQuery(array $parameters)
	{
		$query = [];

		if (!empty($parameters)) {
			foreach ($parameters as $key => $value) {
				if (is_array($value)) {
					foreach ($value as $subValue) {
						$query[] = urlencode($key) . '=' . urlencode($subValue);
					}
				} else {
					$query[] = urlencode($key) . '=' . urlencode($value);
				}
			}
		}

		return implode('&', $query);
	}

	/**
	 * Parses the HTTP response body into a valid array
	 * 
	 * @param Response $response The HTTP response.
	 * 
	 * @return array
	 */
	private function _parseResponse(Response $response)
	{
		$json = $response->getJson();

		if ($json === null) {
			throw new FailedRequestException('The response was empty');
		}

		if ($response->getStatusCode() !== \Cake\Http\Client\Message::STATUS_OK) {
			if (isset($json['error_code']) || isset($json['error'])) {
				throw new FailedRequestException($json['message'] ?? ($json['error_description'] ?? ''));
			}
		}

		if (!$response->isOk()) {
			throw new FailedRequestException();
		}

		return $json;
	}

	/**
	 * Paginates the given results
	 * 
	 * @param Query $query The executed query.
	 * @param Resource[] $results The non-paginated results.
	 * 
	 * @return Resource[]
	 */
	private function _paginateResults(Query $query, array $results)
	{
		$limit = $query->clause('limit');
		$page = $query->clause('page') ?? 1;

		$pages = $limit ? ceil(count($results) / $limit) : 1;

		if ($page > $pages || $page < 1) {
			return [];
		}

		$offset = ($page - 1) * $limit;

		return array_slice($results, $offset, $limit);
	}
}
