<?php

namespace Soldo\Model\Endpoint\Schema;

use Cake\Database\Schema\TableSchemaInterface;
use Muffin\Webservice\Model\Schema;

class SubscriptionSchema extends Schema
{
	public function initialize()
	{
		parent::initialize();

		$this->addColumn('id', [
			'type' => TableSchemaInterface::TYPE_UUID,
			'primaryKey' => true,
		]);
		$this->addColumn('name', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('description', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('platform', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('status', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('wallet_id', [
			'type' => TableSchemaInterface::TYPE_UUID,
		]);
		$this->addColumn('payment_frequency', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('creation_time', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('last_update_time', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
	}
}
