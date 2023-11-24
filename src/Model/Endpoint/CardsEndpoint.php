<?php

namespace Soldo\Model\Endpoint;

use Muffin\Webservice\Model\Endpoint;
use Soldo\Model\Schema\CardSchema;

class CardsEndpoint extends Endpoint
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setPrimaryKey('id');
        $this->setDisplayField('name');

        $this->setSchema(new CardSchema(null));
    }
}
