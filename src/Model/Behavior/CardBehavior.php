<?php

namespace Soldo\Model\Behavior;

use Cake\ORM\Query;
use Soldo\ORM\SoldoBehavior;

class CardBehavior extends SoldoBehavior
{
    use SoldoBehaviorTrait;

    public function findSoldoCards(Query $query, array $options)
    {
        return $this->findSoldoResource($query, $options);
    }
}
