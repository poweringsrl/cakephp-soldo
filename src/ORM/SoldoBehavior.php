<?php

namespace Soldo\ORM;

use Cake\ORM\Behavior;
use Soldo\SoldoAuthenticationTrait;

class SoldoBehavior extends Behavior
{
    use SoldoAuthenticationTrait;

    protected $_defaultConfig = [
        'client_id' => null,
        'client_secret' => null,
        'token' => null,
        'environment' => 'demo',
        'check_credentials_on_instance' => false,
    ];
}
