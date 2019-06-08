<?php

namespace Kregel\LaravelAbstract\Repositories;

use Illuminate\Database\Eloquent\Model;

class GenericRepository
{
    public function findOrCreate(string $model, string $idName, $idValue, array $dataToCreate = [])
    {
        /** @var Model $item */
        $item = $model::where($idName, $idValue)->first();

        if (empty($item)) {
            return $model::create($dataToCreate);
        }

        return $item;
    }
    public function find(string $model, string $idName, $idValue): ?Model
    {
        /** @var Model $item */
        return $model::where($idName, $idValue)->first();
    }
}
