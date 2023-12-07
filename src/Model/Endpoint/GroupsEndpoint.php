<?php

namespace Soldo\Model\Endpoint;

use Soldo\Model\SoldoEndpoint;

class GroupsEndpoint extends SoldoEndpoint
{
	protected bool $_needsFingerprint = false;

	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->setPrimaryKey('id');
		$this->setDisplayField('name');
	}
}
