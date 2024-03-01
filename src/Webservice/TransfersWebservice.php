<?php

namespace Soldo\Webservice;

use Exception;
use Muffin\Webservice\Query;
use Soldo\Error\CreateQueryException;
use Soldo\Error\FailedRequestException;
use Soldo\Model\Endpoint\Schema\Transfer\TransferInputSchema;
use Soldo\Model\Endpoint\Schema\Transfer\TransferResultSchema;

class TransfersWebservice extends SoldoWebservice
{
    public function initialize()
    {
        parent::initialize();

        $this->setEndpoint('wallets/internalTransfer');

        $this->addNestedResource('/:fromWalletId/:toWalletId', [
            'fromWalletId',
            'toWalletId'
        ]);
    }

    public function describe($endpoint)
    {
        return new TransferInputSchema($endpoint);
    }

    protected function _executeCreateQuery(Query $query, array $options = [])
    {
        $data = $query->clause('set');

        if (empty($data['fromWalletId']) || empty($data['toWalletId'])) {
            throw new FailedRequestException('fromWalletId and toWalletId are required');
        }

        if (empty($data['amount'])) {
            throw new FailedRequestException('amount is required');
        }

        if (empty($data['currencyCode'])) {
            throw new FailedRequestException('currencyCode is required');
        }

        $path = $this->nestedResource([
            'fromWalletId' => $data['fromWalletId'],
            'toWalletId' => $data['toWalletId']
        ]);

        if (!is_string($path)) {
            throw new CreateQueryException();
        }

        $url = $this->_baseUrl() . $path;

        try {
            $json = $this->_putRequest($query, $url, $data);
            $query->endpoint()->setSchema(new TransferResultSchema($query->endpoint()->getSchema()->name()));
            return $this->_transformResource($query->endpoint(), $json);
        } catch (Exception $e) {
            return false;
        }
    }

    protected function _executeReadQuery(Query $query, array $options = [])
    {
        return parent::_executeReadQuery($query, $options);
    }

    protected function _executeUpdateQuery(Query $query, array $options = [])
    {
        return parent::_executeUpdateQuery($query, $options);
    }

    protected function _executeDeleteQuery(Query $query, array $options = [])
    {
        return parent::_executeDeleteQuery($query, $options);
    }
}
