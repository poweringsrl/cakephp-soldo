<?php

namespace Soldo\Model\Endpoint;

use Muffin\Webservice\Model\Endpoint;

class GroupsEndpoint extends Endpoint
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setPrimaryKey('id');
        $this->setDisplayField('name');
    }
}
