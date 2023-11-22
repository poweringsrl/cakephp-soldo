<?php

namespace Soldo\Model\Behavior;

use Cake\ORM\Query;
use Soldo\ORM\CustomBehavior;

class WalletBehavior extends CustomBehavior
{
    use SoldoBehaviorTrait;

    public function findSoldoWallets(Query $query, array $options)
    {
        return $this->findSoldoResource($query, $options);
    }
}
