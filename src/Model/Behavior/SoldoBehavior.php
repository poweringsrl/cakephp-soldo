<?php

namespace Soldo\Model\Behavior;

use Cake\ORM\Behavior;
use Soldo\Traits\SoldoAuthenticationTrait;

class SoldoBehavior extends Behavior
{
    use SoldoAuthenticationTrait;
}
