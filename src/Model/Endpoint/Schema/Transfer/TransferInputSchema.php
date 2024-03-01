<?php

namespace Soldo\Model\Endpoint\Schema\Transfer;

use Cake\Database\Schema\TableSchemaInterface;
use Muffin\Webservice\Model\Schema;

class TransferInputSchema extends Schema
{
    public function initialize()
    {
        parent::initialize();

        $this->addColumn('fromWalletId', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('toWalletId', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
        $this->addColumn('amount', [
            'type' => TableSchemaInterface::TYPE_FLOAT,
        ]);
        $this->addColumn('currencyCode', [
            'type' => TableSchemaInterface::TYPE_STRING,
        ]);
    }
}
