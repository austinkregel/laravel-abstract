<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function view(User $user, $model)
    {
        return $user->email === 'github@austinkregel.com';
    }

    /**
     * Need to add this extra index bit so we can be really specific about who we let it.
     * @param  User  $user
     * @return bool
     */
    public function index(User $user)
    {
        return $user->email === 'github@austinkregel.com';
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->email === 'github@austinkregel.com';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user, $model)
    {
        return $user->email === 'github@austinkregel.com';
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $user, $model)
    {
        return $user->email === 'github@austinkregel.com';
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function restore(User $user, $model)
    {
        return $user->email === 'github@austinkregel.com';
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, $model)
    {
        return $user->email === 'github@austinkregel.com';
    }
}
