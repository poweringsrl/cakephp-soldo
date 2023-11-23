<?php

namespace Soldo\Model\Behavior;

use Cake\ORM\Query;
use Soldo\ORM\SoldoBehavior;

class TransactionBehavior extends SoldoBehavior
{
    use SoldoBehaviorTrait;

    public function findSoldoTransactions(Query $query, array $options)
    {
        return $this->findSoldoResource($query, $options);
    }
}
