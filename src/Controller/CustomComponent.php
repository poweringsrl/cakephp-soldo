<?php

namespace Soldo\Controller;

use Cake\Controller\Component;

class CustomComponent extends Component
{
    protected $_defaultConfig = [
        'client_id' => null,
        'client_secret' => null,
        'token' => null,
        'environment' => 'demo',
    ];
}
