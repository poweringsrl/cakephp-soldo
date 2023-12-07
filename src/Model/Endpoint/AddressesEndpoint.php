<?php

namespace Soldo\Model\Endpoint;

use Soldo\Model\SoldoEndpoint;

class AddressesEndpoint extends SoldoEndpoint
{
	protected bool $_needsFingerprint = false;

	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->setPrimaryKey('public_id');
		$this->setDisplayField('public_id');
	}
}
