<?php

namespace Soldo;

use Cake\Core\InstanceConfigTrait;
use Soldo\Soldo;
use Exception;

trait SoldoAuthenticationTrait
{
    use InstanceConfigTrait;

    protected Soldo $Soldo;

    protected $_defaultConfig = [
        'client_id' => null,
        'client_secret' => null,
        'token' => null,
        'environment' => 'demo',
    ];

    public function initialize(array $config)
    {
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
            $this->Soldo = new Soldo([
                'client_id' => $this->getConfig('client_id'),
                'client_secret' => $this->getConfig('client_secret'),
                'environment' => $this->getConfig('environment'),
            ]);
        } catch (Exception $e) {
            throw new Exception();
        }
    }
}
