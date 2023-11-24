<?php

namespace Soldo\Model\Endpoint;

use Muffin\Webservice\Model\Endpoint;

class VehiclesEndpoint extends Endpoint
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setPrimaryKey('id');
        $this->setDisplayField('description');
    }
}
