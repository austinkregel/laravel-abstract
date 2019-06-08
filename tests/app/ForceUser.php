<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class ForceUser extends User
{
    use SoftDeletes;

    protected $table = 'users';
}
