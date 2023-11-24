<?php

namespace Soldo\Model\Endpoint\Schema;

use Cake\Database\Schema\TableSchemaInterface;
use Muffin\Webservice\Model\Schema;

class AddressSchema extends Schema
{
    public function initialize()
    {
        parent::initialize();

        $this->addColumn('public_id', [
            'type' => TableSchemaInterface::TYPE_UUID,
            'primaryKey' => true
        ]);
        $this->addColumn('addressee_name', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('addressee_surname', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('line1', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('line2', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('line3', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('country', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('county', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('city', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('post_code', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('default_shipping', [
            'type' => TableSchemaInterface::TYPE_BOOLEAN,
        ]);
        $this->addColumn('address_type', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('address_category', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('creation_time', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('last_update', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
    }
}
