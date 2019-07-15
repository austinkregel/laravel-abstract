<?php

namespace Kregel\LaravelAbstract;

use Illuminate\Foundation\Auth\User;

/**
 * Class AbstractUser
 * @package Kregel\LaravelAbstract
 * @deprecated
 */
abstract class AbstractUser extends User implements AbstractEloquentModel
{
    use AbstractModelTrait;
}
