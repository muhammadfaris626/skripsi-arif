<?php

namespace App\Policies;

use App\Models\Province;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProvincePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('province: menu') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Province $province): bool
    {
        return $user->hasPermissionTo('province: read') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('province: create') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Province $province): bool
    {
        return $user->hasPermissionTo('province: update') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Province $province): bool
    {
        return $user->hasPermissionTo('province: delete') ? true : false;
    }
}
