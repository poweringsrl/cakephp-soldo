<?php

namespace Soldo\Model\Endpoint;

use Soldo\Model\SoldoEndpoint;

class TransactionsEndpoint extends SoldoEndpoint
{
	protected bool $_needsFingerprint = true;

	protected array $_fingerprintOrder = [
		'id',
		'type',
		'publicId',
		'customReferenceId',
		'groupId',
		'fromDate',
		'toDate',
		'dateType',
		'category',
		'status',
		'tagId',
		'metadataId',
		'expenseType',
		'expenseStatus',
		'text'
	];

	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->setPrimaryKey('id');
		$this->setDisplayField('id');
	}
}
