<?php

namespace Soldo\Model\Behavior;

use Cake\ORM\Query;
use Soldo\ORM\SoldoBehavior;

class GroupBehavior extends SoldoBehavior
{
    use SoldoBehaviorTrait;

    public function findSoldoGroups(Query $query, array $options)
    {
        return $this->findSoldoResource($query, $options);
    }
}
