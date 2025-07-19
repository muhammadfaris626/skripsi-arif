<?php

namespace App\Policies;

use App\Models\FamilyCard;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FamilyCardPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('family-card: menu') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FamilyCard $familyCard): bool
    {
        return $user->hasPermissionTo('family-card: read') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('family-card: create') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FamilyCard $familyCard): bool
    {
        return $user->hasPermissionTo('family-card: update') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FamilyCard $familyCard): bool
    {
        return $user->hasPermissionTo('family-card: delete') ? true : false;
    }
}
