<?php

namespace Soldo\ORM;

use Cake\ORM\Behavior;
use Soldo\SoldoAuthenticationTrait;

class CustomBehavior extends Behavior
{
    use SoldoAuthenticationTrait;

    protected $_defaultConfig = [
        'client_id' => null,
        'client_secret' => null,
        'token' => null,
        'environment' => 'demo',
    ];
}
