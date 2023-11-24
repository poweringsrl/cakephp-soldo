<?php

namespace Soldo\Model\Endpoint\Schema;

use Cake\Database\Schema\TableSchemaInterface;
use Muffin\Webservice\Model\Schema;

class VehicleSchema extends Schema
{
    public function initialize()
    {
        parent::initialize();

        $this->addColumn('id', [
            'type' => TableSchemaInterface::TYPE_UUID,
            'primaryKey' => true
        ]);
        $this->addColumn('number_plate', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('description', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('vat_deductible', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('fuel_type', [
            'type' => TableSchemaInterface::TYPE_STRING,
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
    }
}
