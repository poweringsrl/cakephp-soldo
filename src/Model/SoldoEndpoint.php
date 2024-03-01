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
     * If there are cases in which the fingerprint order of the endpoint for
     * obtaining all of the entities differs from the one of the endpoint for
     * obtaining the single entity, you can merge them so that the order is
     * valid for both. Furthermore, in case it is necessary to insert the
     * primary key field in the fingerprint order, you should not use the one
     * specified by the Soldo documentation, but rather "id". An example of this
     * can be found in the transaction endpoint, where the documentation for the
     * endpoint for obtaining the single entity expects only "transactionId" as
     * a fingerprint order field, but it has been included in the merged one
     * with the name of "id".
     * 
     * @var string[]
     * 
     * @see \Soldo\Model\Endpoint\TransactionsEndpoint::$_fingerprintOrder
     * 
     * @link https://developer.soldo.com/reference/fingerprint-order
     */
    protected array $_fingerprintOrder = [];

    /**
     * Whether this endpoint requires a fingerprint or not
     * 
     * @return bool
     */
    public function needsFingerprint()
    {
        return $this->_needsFingerprint;
    }

    /**
     * The fingerprint order for this endpoint, in case this endpoint requires
     * a fingerprint
     * 
     * @return string[]
     */
    public function getFingerprintOrder()
    {
        return $this->_fingerprintOrder;
    }

    /**
     * Set whether this endpoint requires a fingerprint or not
     * 
     * @param bool $needs_fingerprint Whether this endpoint requires a
     * fingerprint or not.
     * 
     * @return $this
     */
    protected function _setNeedsFingerprint(bool $needs_fingerprint)
    {
        $this->_needsFingerprint = $needs_fingerprint === true;

        return $this;
    }

    /**
     * Set the fingerprint order
     * 
     * @param string[] $fingerprint_order The fingerprint order.
     * 
     * @return $this
     */
    protected function _setFingerprintOrder(array $fingerprint_order)
    {
        $this->_fingerprintOrder = array_values($fingerprint_order);

        return $this;
    }
}
