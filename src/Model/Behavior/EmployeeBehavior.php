<?php

namespace Soldo\Model\Behavior;

use Cake\ORM\Query;
use Soldo\ORM\CustomBehavior;

class EmployeeBehavior extends CustomBehavior
{
    use SoldoBehaviorTrait;

    public function findSoldoEmployees(Query $query, array $options)
    {
        return $this->findSoldoResource($query, $options);
    }
}
