<?php

namespace Soldo\Model\Behavior;

use Cake\ORM\Query;
use Soldo\ORM\CustomBehavior;

class GroupBehavior extends CustomBehavior
{
    use SoldoBehaviorTrait;

    public function findSoldoGroups(Query $query, array $options)
    {
        return $this->findSoldoResource($query, $options);
    }
}
