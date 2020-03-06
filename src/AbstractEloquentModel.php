<?php

namespace Kregel\LaravelAbstract;

use Illuminate\Database\Eloquent\Builder;

interface AbstractEloquentModel
{
    public function getValidationCreateRules(): array;
    public function getValidationUpdateRules(): array;
    public function getAbstractAllowedFilters(): array;
    public function getAbstractAllowedRelationships(): array;
    public function getAbstractAllowedSorts(): array;
    public function getAbstractAllowedFields(): array;
    public function getAbstractSearchableFields(): array;
    public function scopeQ(Builder $query, string $string): void;
    public function usesSoftdeletes(): bool;
}
