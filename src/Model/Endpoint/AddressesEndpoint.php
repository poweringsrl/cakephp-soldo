<?php

namespace Soldo\Model\Endpoint;

use Muffin\Webservice\Model\Endpoint;

class AddressesEndpoint extends Endpoint
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setPrimaryKey('public_id');
        $this->setDisplayField('public_id');
    }
}
