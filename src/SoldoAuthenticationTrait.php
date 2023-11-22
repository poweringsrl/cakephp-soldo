<?php

namespace Soldo;

use Cake\Core\InstanceConfigTrait;
use Exception;
use Soldo\Authentication\OAuthCredential;
use Soldo\Core\Exception\EmptyCredentialsException;
use Soldo\Core\Exception\FailedAuthenticationException;
use Soldo\Core\Exception\InvalidEnvironmentException;

trait SoldoAuthenticationTrait
{
    use InstanceConfigTrait;

    protected Soldo $Sdk;

    public function initialize(array $config)
    {
        $this->setConfig('check_credentials_on_instance', boolval($this->getConfig('check_credentials_on_instance')));

        $config = $this->getConfig();

        if (
            empty($config['client_id'])
            || empty($config['client_secret'])
        ) {
            throw new EmptyCredentialsException();
        }

        if (
            $config['environment'] !== 'live'
            && $config['environment'] !== 'demo'
        ) {
            throw new InvalidEnvironmentException();
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

            $this->Sdk = new Soldo([
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'environment' => $environment,
            ]);
        } catch (Exception $e) {
            throw new FailedAuthenticationException();
        }
    }
}
