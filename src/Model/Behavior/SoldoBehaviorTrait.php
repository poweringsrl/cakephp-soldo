<?php

namespace Soldo\Model\Behavior;

use Cake\Collection\Collection;
use Cake\ORM\Query;
use Exception;
use Soldo\Utils\Paginator;
use Soldo\WithSoldoSdkTrait;

trait SoldoBehaviorTrait
{
    use WithSoldoSdkTrait;

    protected function findSoldoResource(Query $query, array $options)
    {
        if (preg_match('/(\w+)Behavior/', static::class, $matches) !== 1) {
            throw new Exception();
        }

        $resource = ucfirst($matches[1]);

        $data = isset($options['id'])
            ? $this->getFromSdk($resource, strval($options['id']))
            : $this->getListFromSdk($resource);

        return $query->setResult(new Collection(is_array($data) ? $data : [$data]));
    }

    private function getFromSdk(string $resource, string $id)
    {
        $method = 'get' . $resource;

        if (!method_exists($this->Sdk, $method)) {
            throw new Exception();
        }

        try {
            return $this->Sdk->{$method}($id);
        } catch (Exception $e) {
            throw new Exception();
        }
    }

    private function getListFromSdk(string $resource, int $page = 0, array $prev_results = [])
    {
        $method = 'get' . $resource . 's';

        if (!(method_exists($this->Sdk, $method))) {
            throw new Exception();
        }

        try {
            $results = $this->Sdk->{$method}($page, Paginator::MAX_ALLOWED_ITEMS_PER_PAGE);

            if (count($results) === Paginator::MAX_ALLOWED_ITEMS_PER_PAGE) {
                $results = $this->getListFromSdk($resource, ++$page, $results);
            }
        } catch (Exception $e) {
            throw new Exception();
        }

        return array_merge($results, $prev_results);
    }
}
