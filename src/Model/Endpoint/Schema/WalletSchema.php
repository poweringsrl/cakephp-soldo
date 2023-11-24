<?php

namespace Soldo\Model\Endpoint\Schema;

use Cake\Database\Schema\TableSchemaInterface;
use Muffin\Webservice\Model\Schema;

class WalletSchema extends Schema
{
    public function initialize()
    {
        parent::initialize();

        $this->addColumn('id', [
            'type' => TableSchemaInterface::TYPE_UUID,
            'primaryKey' => true
        ]);
        $this->addColumn('name', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('currency_code', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('available_amount', [
            'type' => TableSchemaInterface::TYPE_FLOAT,
        ]);
        $this->addColumn('blocked_amount', [
            'type' => TableSchemaInterface::TYPE_FLOAT,
        ]);
        $this->addColumn('primary_user_type', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('visible', [
            'type' => TableSchemaInterface::TYPE_BOOLEAN,
        ]);
        $this->addColumn('creation_time', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('last_update', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
    }
}
