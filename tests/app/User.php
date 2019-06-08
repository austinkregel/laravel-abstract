<?php

namespace App;

use Kregel\LaravelAbstract\AbstractUser as Authenticatable;

class User extends Authenticatable
{
    public const VALIDATION_CREATE_RULES = [
        'name' => 'required',
        'email' => 'required',
        'password' => 'required',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAbstractAllowedFilters(): array
    {
        return [];
    }

    public function getAbstractAllowedRelationships(): array
    {
        return [];
    }

    public function getAbstractAllowedSorts(): array
    {
        return [];
    }

    public function getAbstractAllowedFields(): array
    {
        return [];
    }

    public function getAbstractSearchableFields(): array
    {
        return [
            'name'
        ];
    }
}
