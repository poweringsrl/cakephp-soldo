<?php

namespace Soldo\Controller;

use Cake\Controller\Component;
use Soldo\SoldoAuthenticationTrait;

class CustomComponent extends Component
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
