<?php

namespace App\Policies;

use App\Models\Rank;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RankPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('rank: menu') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Rank $rank): bool
    {
        return $user->hasPermissionTo('rank: read') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('rank: create') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Rank $rank): bool
    {
        return $user->hasPermissionTo('rank: update') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Rank $rank): bool
    {
        return $user->hasPermissionTo('rank: delete') ? true : false;
    }
}
