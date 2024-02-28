<?php

namespace Soldo\Webservice;

use Muffin\Webservice\Query;
use Muffin\Webservice\ResultSet;
use Muffin\Webservice\Webservice\Webservice;
use Soldo\Error\FailedRequestException;
use Soldo\Error\InvalidFingerprintException;
use Soldo\Error\NoAdvancedCredentialsException;
use Soldo\Error\ReadQueryException;

class SoldoWebservice extends Webservice
{
	protected const API_ENTRY_POINT = '/business/v2';
	protected const MAX_ITEMS_PER_PAGE = 50;

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

		$limit = $query->clause('limit');

		// In CakePHP pages are expected to start from 1, while Soldo expect pages starting from 0
		$page = ($query->clause('page') ?? 1) - 1;

		$all = !$limit || $limit > self::MAX_ITEMS_PER_PAGE;

		$json = $all
			? $this->_sendRequest($query, $parameters, $all)
			: $this->_sendRequest($query, $parameters, $all, $page, $limit);

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

	protected function _baseUrl()
	{
		return '/' . trim(static::API_ENTRY_POINT, '/') . '/' . $this->getEndpoint();
	}

	protected function _sendRequest(
		Query $query,
		array $parameters,
		bool $all = false,
		int $page = 0,
		int $limit = self::MAX_ITEMS_PER_PAGE,
		array $prev_json = []
	) {
		$url = $this->_baseUrl();

		$primary_key = $query->endpoint()->getPrimaryKey();
		if ($primary_key && isset($parameters[$primary_key])) {
			$url .= '/' . $parameters[$primary_key];
			unset($parameters[$primary_key]);
		}

		$parameters['p'] = $page;
		$parameters['s'] = $all ? self::MAX_ITEMS_PER_PAGE : $limit;

		$resource_endpoint_class = 'Soldo\Model\Endpoint\\' . $query->endpoint()->getAlias() . 'Endpoint';

		/** @var \Soldo\Model\SoldoEndpoint $resource_endpoint */
		$resource_endpoint = new $resource_endpoint_class;

		$headers = [];
		if ($resource_endpoint->_needsFingerprint()) {
			$token = $this->getDriver()->getConfig('token');
			$base64_private_key = $this->getDriver()->getConfig('private_key');

			if (empty($token) || empty($base64_private_key)) {
				throw new NoAdvancedCredentialsException();
			}

			$private_key = base64_decode($base64_private_key);

			$fingerprint = $this->_generateFingerprint($resource_endpoint->_fingerprintOrder(), $parameters, $token);
			$fingerprint_signature = $this->_generateFingerprintSignature($fingerprint, $private_key);

			$headers = [
				'X-Soldo-Fingerprint' => $fingerprint,
				'X-Soldo-Fingerprint-Signature' => $fingerprint_signature,
			];
		}

		$response = $this->getDriver()
			->getClient()
			->get($url, $parameters, $headers ? ['headers' => $headers] : []);

		$json = $response->getJson();

		if ($response->getStatusCode() !== \Cake\Http\Client\Message::STATUS_OK) {
			if (isset($json['error_code']) || isset($json['error'])) {
				throw new FailedRequestException($json['message'] ?? ($json['error_description'] ?? ''));
			}
		}

		if (!$response->isOk()) {
			throw new FailedRequestException();
		}

		if (isset($json['results'])) {
			if ($all && count($json['results']) === self::MAX_ITEMS_PER_PAGE) {
				$json = $this->_sendRequest($query, $parameters, $all, ++$page, $limit, $json);
			}

			$json['results'] = array_merge($prev_json['results'] ?? [], $json['results']);
		}

		return $json;
	}

	protected function _paginateResults(Query $query, array $results)
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

	private function _generateFingerprint(array $fingerprint_order, array $parameters, string $token)
	{
		$data = $token;

		if (!empty($fingerprint_order) && !empty($parameters)) {
			foreach (array_reverse(array_values($fingerprint_order)) as $parameter) {
				if (isset($parameters[$parameter]) && !empty($parameters[$parameter])) {
					$data = $parameters[$parameter] . $data;
				}
			}
		}

		return hash('sha512', $data);
	}

	private function _generateFingerprintSignature(string $fingerprint, string $private_key)
	{
		$private_key_resource = openssl_pkey_get_private($private_key);

		if (!$private_key_resource) {
			throw new InvalidFingerprintException('Could not retrieve the private key needed for the advanced authentication');
		}

		$fingerprint_signature = '';
		if (openssl_sign($fingerprint, $fingerprint_signature, $private_key_resource, OPENSSL_ALGO_SHA512)) {
			$base64_fingerprint_signature = base64_encode($fingerprint_signature);
			openssl_free_key($private_key_resource);

			return $base64_fingerprint_signature;
		} else {
			throw new InvalidFingerprintException('Could not generate the signature for the private key needed for the advanced authentication');
		}
	}
}
