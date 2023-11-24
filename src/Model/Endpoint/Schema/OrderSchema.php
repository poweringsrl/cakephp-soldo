<?php

namespace Soldo\Model\Endpoint\Schema;

use Cake\Database\Schema\TableSchemaInterface;
use Muffin\Webservice\Model\Schema;

class OrderSchema extends Schema
{
	public function initialize()
	{
		parent::initialize();

		$this->addColumn('id', [
			'type' => TableSchemaInterface::TYPE_UUID,
			'primaryKey' => true,
		]);
		$this->addColumn('status', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('creation_time', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('last_update_time', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('is_valid', [
			'type' => TableSchemaInterface::TYPE_BOOLEAN,
		]);
		$this->addColumn('total_paid_amount', [
			'type' => TableSchemaInterface::TYPE_FLOAT,
		]);
		$this->addColumn('total_paid_currency', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
	}
}
