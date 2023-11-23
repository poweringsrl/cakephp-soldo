<?php

namespace Soldo\Webservice;

use Exception;
use Muffin\Webservice\Query;
use Muffin\Webservice\ResultSet;
use Muffin\Webservice\Webservice\Webservice;

class SoldoWebservice extends Webservice
{
    protected const API_ENTRY_POINT = '/business/v2';
    protected const API_PATH = '/';
    protected const MAX_ITEMS_PER_PAGE = 50;

    protected function _baseUrl()
    {
        return '/' . trim(static::API_ENTRY_POINT, '/') . '/' . $this->getEndpoint();
    }

    protected function _executeReadQuery(Query $query, array $options = [])
    {
        $parameters = $query->where();

        if ($query->clause('page')) {
            // Cake\Database\Query::page expect pages starting from 1, while Soldo expect pages starting from 0
            $parameters['p'] = $query->clause('page') - 1;
        }

        if ($query->clause('limit')) {
            $parameters['s'] = max($query->clause('limit'), self::MAX_ITEMS_PER_PAGE);
        }

        $url = $this->_baseUrl() . '/' . static::API_PATH;

        $response = $this->getDriver()->getClient()->get($url, $parameters);

        $json = $response->getJson();

        if (isset($json['error_code'])) {
            throw new Exception($json['message']);
        }

        if (!$response->isOk()) {
            throw new Exception();
        }

        if (!isset($json['results'])) {
            $resource = $this->_transformResource($query->endpoint(), $json);

            return new ResultSet([$resource], 1);
        }

        $resources = $this->_transformResults($query->endpoint(), $json['results']);

        return new ResultSet($resources, count($resources));
    }
}
