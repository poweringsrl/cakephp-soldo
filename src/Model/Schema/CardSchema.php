<?php

namespace Soldo\Model\Schema;

use Muffin\Webservice\Model\Schema;

class CardSchema extends Schema
{
    public function initialize()
    {
        parent::initialize();

        $this->addColumn('id', [
            'type' => 'integer',
            'primaryKey' => true
        ]);
        $this->addColumn('name', [
            'type' => 'string',
        ]);
        $this->addColumn('masked_pan', [
            'type' => 'string',
        ]);
        $this->addColumn('expiration_date', [
            'type' => 'string',
        ]);
        $this->addColumn('creation_time', [
            'type' => 'string',
        ]);
        $this->addColumn('last_update', [
            'type' => 'string',
        ]);
        $this->addColumn('type', [
            'type' => 'string',
        ]);
        $this->addColumn('status', [
            'type' => 'string',
        ]);
        $this->addColumn('owner_type', [
            'type' => 'string',
        ]);
        $this->addColumn('wallet_id', [
            'type' => 'string',
        ]);
        $this->addColumn('currency_code', [
            'type' => 'string',
        ]);
        $this->addColumn('emboss_line4', [
            'type' => 'string',
        ]);
        $this->addColumn('active', [
            'type' => 'boolean',
        ]);
        $this->addColumn('method3ds', [
            'type' => 'string',
        ]);
    }
}
