<?php

namespace Kregel\LaravelAbstract;

interface AbstractEloquentModel
{
    public const VALIDATION_CREATE_RULES = [];
    public const VALIDATION_UPDATE_RULES = [];
    public function getAbstractAllowedFilters(): array;
    public function getAbstractAllowedRelationships(): array;
    public function getAbstractAllowedSorts(): array;
    public function getAbstractAllowedFields(): array;
    public function getAbstractSearchableFields(): array;
}
