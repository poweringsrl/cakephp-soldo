<?php

namespace Soldo\Webservice;

use Exception;
use Muffin\Webservice\Query;
use Muffin\Webservice\ResultSet;
use Muffin\Webservice\Webservice\Webservice;

class SoldoWebservice extends Webservice
{
    protected const API_ENTRY_POINT = '/business/v2';
    protected const MAX_ITEMS_PER_PAGE = 50;

    protected function _executeReadQuery(Query $query, array $options = [])
    {
        $parameters = $query->where();

        if ($query->clause('order')) {
            $order = array_filter(array_map(function (string $direction) {
                return strtoupper($direction);
            }, $query->clause('order')), function (string $direction, string $field) {
                return in_array($direction, ['ASC', 'DESC']);
            }, ARRAY_FILTER_USE_BOTH);

            // Currently Soldo supports only one order clause at the same time
            if (count($order) > 1) {
                throw new Exception();
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

        $resources = $this->_transformResults($query->endpoint(), isset($json['results']) ? $json['results'] : [$json]);
        $resources = is_array($resources) ? $resources : [$resources];

        return new ResultSet($all ? $this->_filterResults($query, $resources) : $resources, count($resources));
    }

    protected function _baseUrl()
    {
        return '/' . trim(static::API_ENTRY_POINT, '/') . '/' . $this->getEndpoint();
    }

    protected function _sendRequest(Query $query, array $parameters, bool $all = false, int $page = 0, int $limit = self::MAX_ITEMS_PER_PAGE, array $prev_json = [])
    {
        $url = $this->_baseUrl();

        $primary_key = $query->endpoint()->getPrimaryKey();
        if ($primary_key && isset($parameters[$primary_key])) {
            $url .= '/' . $parameters[$primary_key];
            unset($parameters[$primary_key]);
        }

        $parameters['p'] = $page;
        $parameters['s'] = $all ? self::MAX_ITEMS_PER_PAGE : $limit;

        $response = $this->getDriver()->getClient()->get($url, $parameters);

        $json = $response->getJson();

        if (isset($json['error_code'])) {
            throw new Exception($json['message']);
        }

        if (!$response->isOk()) {
            throw new Exception();
        }

        if (isset($json['results'])) {
            if ($all && count($json['results']) === self::MAX_ITEMS_PER_PAGE) {
                $json = $this->_sendRequest($query, $parameters, $all, ++$page, $limit, $json);
            }

            $json['results'] = array_merge($prev_json['results'] ?? [], $json['results']);
        }

        return $json;
    }

    protected function _filterResults(Query $query, array $results)
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
