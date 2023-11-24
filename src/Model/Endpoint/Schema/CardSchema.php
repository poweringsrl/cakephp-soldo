<?php

namespace Soldo\Model\Endpoint\Schema;

use Cake\Database\Schema\TableSchemaInterface;
use Muffin\Webservice\Model\Schema;

class CardSchema extends Schema
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
		$this->addColumn('masked_pan', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('expiration_date', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('creation_time', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('last_update', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('type', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('status', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('owner_type', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('wallet_id', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('currency_code', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('emboss_line4', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('active', [
			'type' => TableSchemaInterface::TYPE_BOOLEAN,
		]);
		$this->addColumn('method3ds', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
	}
}
