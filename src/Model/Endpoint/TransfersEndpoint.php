<?php

namespace Soldo\Model\Endpoint;

use Soldo\Model\Endpoint\Schema\Transfer\TransferInputSchema;
use Soldo\Model\SoldoEndpoint;

class TransfersEndpoint extends SoldoEndpoint
{
    protected bool $_needsFingerprint = true;

    protected array $_fingerprintOrder = [
        'amount',
        'currencyCode',
        'fromWalletId',
        'toWalletId',
    ];

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setSchema(new TransferInputSchema('Transfers'));
    }
}
