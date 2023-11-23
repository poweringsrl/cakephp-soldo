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
    protected const MAX_RESULTS = 1000;

    protected function _executeReadQuery(Query $query, array $options = [])
    {
        $parameters = $query->where();

        $json = $this->_sendRequest($parameters);

        if (isset($json['results'])) {
            $resources = $this->_transformResults($query->endpoint(), $json['results']);

            return new ResultSet($resources, count($resources));
        }

        $resource = $this->_transformResource($query->endpoint(), $json);

        return new ResultSet([$resource], 1);
    }

    protected function _baseUrl()
    {
        return '/' . trim(static::API_ENTRY_POINT, '/') . '/' . $this->getEndpoint();
    }

    protected function _sendRequest(array $parameters, int $page = 0, array $prev_results = [])
    {
        $url = $this->_baseUrl();

        $parameters['p'] = $page;
        $parameters['s'] = self::MAX_ITEMS_PER_PAGE;

        $response = $this->getDriver()->getClient()->get($url, $parameters);

        if (!$response->isOk()) {
            throw new Exception();
        }

        $json = $response->getJson();

        if (isset($json['error_code'])) {
            throw new Exception($json['message']);
        }

        if (!isset($json['results'])) {
            return $json;
        }

        $json['results'] = array_merge($this->_sendRequest($parameters, ++$page, $json['results'], $prev_results));
        return $json;
    }
}
