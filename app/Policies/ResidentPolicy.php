<?php

namespace App\Policies;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ResidentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('resident: menu') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Resident $resident): bool
    {
        return $user->hasPermissionTo('resident: read') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('resident: create') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Resident $resident): bool
    {
        return $user->hasPermissionTo('resident: update') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Resident $resident): bool
    {
        return $user->hasPermissionTo('resident: delete') ? true : false;
    }
}
