<?php

namespace Soldo\Model\Endpoint;

use Muffin\Webservice\Model\Endpoint;

class RolesEndpoint extends Endpoint
{
	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->setPrimaryKey('name');
		$this->setDisplayField('description');
	}
}
