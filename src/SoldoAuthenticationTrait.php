<?php

namespace Soldo;

use Cake\Core\InstanceConfigTrait;
use Soldo\Soldo;
use Exception;
use Soldo\Authentication\OAuthCredential;

trait SoldoAuthenticationTrait
{
    use InstanceConfigTrait;

    protected Soldo $Soldo;

    public function initialize(array $config)
    {
        $this->setConfig('check_credentials_on_instance', boolval($this->getConfig('check_credentials_on_instance')));

        $config = $this->getConfig();

        if (
            empty($config['client_id'])
            || empty($config['client_secret'])
        ) {
            throw new Exception();
        }

        if (
            $config['environment'] !== 'live'
            && $config['environment'] !== 'demo'
        ) {
            throw new Exception();
        }

        $this->authenticate();
    }

    private function authenticate()
    {
        try {
            $client_id = $this->getConfig('client_id');
            $client_secret = $this->getConfig('client_secret');
            $environment = $this->getConfig('environment');

            if ($this->getConfig('check_credentials_on_instance')) {
                $credential = new OAuthCredential($client_id, $client_secret);
                $client = new SoldoClient($credential, $environment);
                $client->getAccessToken();
            }

            $this->Soldo = new Soldo([
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'environment' => $environment,
            ]);
        } catch (Exception $e) {
            throw new Exception();
        }
    }
}
