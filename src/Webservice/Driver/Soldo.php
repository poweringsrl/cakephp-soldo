<?php

namespace Soldo\Webservice\Driver;

use Cake\Http\Client;
use Exception;
use Muffin\Webservice\AbstractDriver;
use Soldo\Http\Client\Adapter\SoldoCurl;

class Soldo extends AbstractDriver
{
    protected const API_PRODUCTION_HOST = 'api.soldo.com';
    protected const API_DEMO_HOST = 'api-demo.soldocloud.net';
    protected const API_ENTRY_POINT = '/business/v2';
    protected const API_AUTHORIZE_PATH = '/oauth/authorize';

    public function initialize()
    {
        $environment = $this->getConfig('environment');

        if (!in_array($environment, ['production', 'demo'])) {
            throw new Exception();
        }

        $host = $environment === 'production'
            ? self::API_PRODUCTION_HOST
            : self::API_DEMO_HOST;

        $authorizer = new Client([
            'host' => $host,
            'scheme' => 'https',
        ]);

        $client_id = $this->getConfig('client_id');
        $client_secret = $this->getConfig('client_secret');

        if (empty($client_id) || empty($client_secret)) {
            throw new Exception();
        }

        $response = $authorizer->post(self::API_AUTHORIZE_PATH, ['client_id' => $client_id, 'client_secret' => $client_secret]);

        if (!$response->isOk()) {
            throw new Exception();
        }

        $data = $response->getJson();

        if (empty($data['access_token'])) {
            throw new Exception();
        }

        $token = $data['access_token'];

        $adapter = new SoldoCurl($token);

        $this->setClient(new Client([
            'adapter' => $adapter,
            'host' => $host . self::API_ENTRY_POINT,
            'scheme' => 'https',
        ]));
    }
}
