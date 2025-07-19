<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Work;
use Illuminate\Auth\Access\Response;

class WorkPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('work: menu') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Work $work): bool
    {
        return $user->hasPermissionTo('work: read') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('work: create') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Work $work): bool
    {
        return $user->hasPermissionTo('work: update') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Work $work): bool
    {
        return $user->hasPermissionTo('work: delete') ? true : false;
    }
}
