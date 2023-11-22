<?php

namespace Soldo\Model\Behavior;

use Cake\ORM\Query;
use Soldo\ORM\CustomBehavior;

class CardBehavior extends CustomBehavior
{
    use SoldoBehaviorTrait;

    public function findSoldoCards(Query $query, array $options)
    {
        return $this->findSoldoResource($query, $options);
    }
}
