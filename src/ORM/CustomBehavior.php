<?php

namespace Soldo\ORM;

use Cake\ORM\Behavior;
use Soldo\SoldoAuthenticationTrait;

class CustomBehavior extends Behavior
{
    use SoldoAuthenticationTrait;
}
