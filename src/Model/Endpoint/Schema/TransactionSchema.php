<?php

namespace Soldo\Model\Endpoint\Schema;

use Cake\Database\Schema\TableSchemaInterface;
use Muffin\Webservice\Model\Schema;

class TransactionSchema extends Schema
{
	public function initialize()
	{
		parent::initialize();

		$this->addColumn('id', [
			'type' => TableSchemaInterface::TYPE_STRING,
			'primaryKey' => true,
		]);
		$this->addColumn('wallet_id', [
			'type' => TableSchemaInterface::TYPE_UUID,
		]);
		$this->addColumn('wallet_name', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('status', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('category', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('transaction_sign', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('amount', [
			'type' => TableSchemaInterface::TYPE_FLOAT,
		]);
		$this->addColumn('amount_currency', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('tx_amount', [
			'type' => TableSchemaInterface::TYPE_FLOAT,
		]);
		$this->addColumn('tx_amount_currency', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('fee_amount', [
			'type' => TableSchemaInterface::TYPE_FLOAT,
		]);
		$this->addColumn('fee_currency', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('expense_status', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('expense_type', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('expense_report_id', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('date', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('settlement_date', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('update_time', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('group_id', [
			'type' => TableSchemaInterface::TYPE_UUID,
		]);
		$this->addColumn('owner_type', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('has_attachments', [
			'type' => TableSchemaInterface::TYPE_BOOLEAN,
		]);
		$this->addColumn('notes', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
		$this->addColumn('tx_id', [
			'type' => TableSchemaInterface::TYPE_STRING,
		]);
	}
}
