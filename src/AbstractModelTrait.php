<?php

namespace Kregel\LaravelAbstract;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

trait AbstractModelTrait
{
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
}
