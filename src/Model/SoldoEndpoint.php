<?php

namespace Soldo\Model;

use Muffin\Webservice\Model\Endpoint;

class SoldoEndpoint extends Endpoint
{
    protected bool $_needsFingerprint = false;

    protected array $_fingerprintOrder = [];

    public function _needsFingerprint()
    {
        return $this->_needsFingerprint;
    }

    public function _fingerprintOrder()
    {
        return $this->_fingerprintOrder;
    }
}
