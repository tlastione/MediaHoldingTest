<?php

namespace App\Traits;

trait HandleEntityConfig
{
    protected function getEndpoint(string $entity, string $action): string
    {
        $endpoints = config('api_endpoints');

        if (!isset($endpoints[$entity][$action])) {
            throw new \Exception('This action is not supported for the entity: ' . $entity);
        }

        return $endpoints[$entity][$action];
    }
}