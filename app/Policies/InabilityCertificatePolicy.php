<?php

namespace App\Policies;

use App\Models\InabilityCertificate;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InabilityCertificatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('inability-certificate: menu') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InabilityCertificate $inabilityCertificate): bool
    {
        return $user->hasPermissionTo('inability-certificate: read') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('inability-certificate: create') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InabilityCertificate $inabilityCertificate): bool
    {
        return $user->hasPermissionTo('inability-certificate: update') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InabilityCertificate $inabilityCertificate): bool
    {
        return $user->hasPermissionTo('inability-certificate: delete') ? true : false;
    }
}
