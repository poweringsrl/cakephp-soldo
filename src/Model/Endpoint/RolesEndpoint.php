<?php

namespace Soldo\Model\Endpoint;

use Soldo\Model\SoldoEndpoint;

class RolesEndpoint extends SoldoEndpoint
{
	protected bool $_needsFingerprint = false;

	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->setPrimaryKey('name');
		$this->setDisplayField('description');
	}
}
