<?php

namespace Soldo\Model\Behavior;

use Cake\ORM\Query;
use Soldo\ORM\SoldoBehavior;

class EmployeeBehavior extends SoldoBehavior
{
    use SoldoBehaviorTrait;

    public function findSoldoEmployees(Query $query, array $options)
    {
        return $this->findSoldoResource($query, $options);
    }
}
