<?php

namespace Soldo\Webservice;

use Muffin\Webservice\Query;
use Muffin\Webservice\ResultSet;
use Muffin\Webservice\Webservice\Webservice;

class CardsWebservice extends Webservice
{
    protected function _executeReadQuery(Query $query, array $options = [])
    {
        $response = $this->getDriver()->getClient()->get('/cards');

        if (!$response->isOk()) {
            return false;
        }

        $resources = $this->_transformResults($query->endpoint(), $response->getJson()['results']);

        return new ResultSet($resources, count($resources));
    }
}
