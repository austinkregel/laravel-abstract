<?php

namespace Kregel\LaravelAbstract;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractEloquentModel extends Model
{
public const ALLOWED_FILTERS = [];
public const ALLOWED_RELATIONSHIPS = [];
public const ALLOWED_SORTS = [];
public const ALLOWED_FIELDS = [];
public const VALIDATION_CREATE_RULES = [];
public const VALIDATION_UPDATE_RULES = [];

public const SEARCHABLE_FIELDS = [];

    public function scopeQ(Builder $query, string $string)
    {
        foreach (static::SEARCHABLE_FIELDS as $field) {
            $query->orWhere($field, 'like', '%' . $string . '%');
        }
    }
}
