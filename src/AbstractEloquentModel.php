<?php

namespace Kregel\LaravelAbstract;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class AbstractEloquentModel extends Model
{
    public const VALIDATION_CREATE_RULES = [];
    public const VALIDATION_UPDATE_RULES = [];

    public function scopeQ(Builder $query, string $string)
    {
        $fields = $this->getAbstractSearchableFields();

        foreach ($fields as $field) {
            $query->orWhere($field, 'like', '%'.$string.'%');
        }
    }

    public function usesSoftdeletes()
    {
        return in_array(SoftDeletes::class, class_uses($this));
    }

    abstract public function getAbstractAllowedFilters(): array;
    abstract public function getAbstractAllowedRelationships(): array;
    abstract public function getAbstractAllowedSorts(): array;
    abstract public function getAbstractAllowedFields(): array;
    abstract public function getAbstractSearchableFields(): array;
}
