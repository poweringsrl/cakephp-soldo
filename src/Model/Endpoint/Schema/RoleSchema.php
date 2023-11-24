<?php

namespace Soldo\Model\Endpoint\Schema;

use Cake\Database\Schema\TableSchemaInterface;
use Muffin\Webservice\Model\Schema;

class RoleSchema extends Schema
{
    public function initialize()
    {
        parent::initialize();

        $this->addColumn('name', [
            'type' => TableSchemaInterface::TYPE_STRING,
            'primaryKey' => true
        ]);
        $this->addColumn('description', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('category', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
    }
}
