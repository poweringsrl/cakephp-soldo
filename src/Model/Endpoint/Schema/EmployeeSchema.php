<?php

namespace Soldo\Model\Endpoint\Schema;

use Cake\Database\Schema\TableSchemaInterface;
use Muffin\Webservice\Model\Schema;

class EmployeeSchema extends Schema
{
    public function initialize()
    {
        parent::initialize();

        $this->addColumn('id', [
            'type' => TableSchemaInterface::TYPE_STRING,
            'primaryKey' => true
        ]);
        $this->addColumn('name', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('surname', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('email', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('mobile', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('status', [
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
