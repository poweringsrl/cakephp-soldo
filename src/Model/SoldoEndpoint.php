<?php

namespace Soldo\Model;

use Muffin\Webservice\Model\Endpoint;

class SoldoEndpoint extends Endpoint
{
    /**
     * Whether this endpoint requires a fingerprint or not
     * 
     * @var bool
     */
    protected bool $_needsFingerprint = false;

    /**
     * The fingerprint order for this endpoint, in case this endpoint requires
     * a fingerprint
     *
     * @var string[]
     */
    protected array $_fingerprintOrder = [];

    /**
     * Whether this endpoint requires a fingerprint or not
     * 
     * @return bool
     */
    public function _needsFingerprint()
    {
        return $this->_needsFingerprint;
    }

    /**
     * The fingerprint order for this endpoint, in case this endpoint requires
     * a fingerprint
     * 
     * @return string[]
     */
    public function _fingerprintOrder()
    {
        return $this->_fingerprintOrder;
    }
}
