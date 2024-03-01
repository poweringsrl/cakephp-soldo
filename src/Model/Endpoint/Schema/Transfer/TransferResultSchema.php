<?php

namespace Soldo\Model\Endpoint\Schema\Transfer;

use Cake\Database\Schema\TableSchemaInterface;
use Muffin\Webservice\Model\Schema;

class TransferResultSchema extends Schema
{
    public function initialize()
    {
        parent::initialize();

        $this->addColumn('amount', [
            'type' => TableSchemaInterface::TYPE_FLOAT,
        ]);
        $this->addColumn('datetime', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('from_wallet', [
            'type' => TableSchemaInterface::TYPE_JSON,
        ]);
        $this->addColumn('to_wallet', [
            'type' => TableSchemaInterface::TYPE_JSON,
        ]);
    }
}
