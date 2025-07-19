<?php

namespace App\Policies;

use App\Models\UnmarriedCertificate;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UnmarriedCertificatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('unmarried-certificate: menu') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UnmarriedCertificate $unmarriedCertificate): bool
    {
        return $user->hasPermissionTo('unmarried-certificate: read') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('unmarried-certificate: create') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UnmarriedCertificate $unmarriedCertificate): bool
    {
        return $user->hasPermissionTo('unmarried-certificate: update') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UnmarriedCertificate $unmarriedCertificate): bool
    {
        return $user->hasPermissionTo('unmarried-certificate: delete') ? true : false;
    }
}
