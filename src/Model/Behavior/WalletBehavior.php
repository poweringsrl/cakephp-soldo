<?php

namespace Soldo\Model\Behavior;

use Cake\ORM\Query;
use Soldo\ORM\SoldoBehavior;

class WalletBehavior extends SoldoBehavior
{
    use SoldoBehaviorTrait;

    public function findSoldoWallets(Query $query, array $options)
    {
        return $this->findSoldoResource($query, $options);
    }
}
