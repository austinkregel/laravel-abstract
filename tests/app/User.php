<?php

namespace App;

use Kregel\LaravelAbstract\AbstractUser as Authenticatable;

class User extends Authenticatable
{
    public function getValidationCreateRules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ];
    }
    public function getValidationUpdateRules(): array
    {
        return [
            'name' => 'required'
        ];
    }

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
