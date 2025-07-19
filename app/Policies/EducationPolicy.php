<?php

namespace App\Policies;

use App\Models\Education;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EducationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('education: menu') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Education $education): bool
    {
        return $user->hasPermissionTo('education: read') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('education: create') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Education $education): bool
    {
        return $user->hasPermissionTo('education: update') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Education $education): bool
    {
        return $user->hasPermissionTo('education: delete') ? true : false;
    }
}
