<?php

namespace Soldo\Model\Endpoint\Schema;

use Cake\Database\Schema\TableSchemaInterface;
use Muffin\Webservice\Model\Schema;

class GroupSchema extends Schema
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
        $this->addColumn('type', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('custom_reference_id', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('note', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
    }
}
