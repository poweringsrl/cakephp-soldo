<?php

namespace Soldo\ORM;

use Cake\ORM\Behavior;

class CustomBehavior extends Behavior
{
    protected $_defaultConfig = [
        'client_id' => null,
        'client_secret' => null,
        'token' => null,
        'environment' => 'demo',
    ];
}
