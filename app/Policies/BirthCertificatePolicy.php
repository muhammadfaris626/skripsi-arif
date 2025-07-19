<?php

namespace App\Policies;

use App\Models\BirthCertificate;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BirthCertificatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('birth-certificate: menu') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BirthCertificate $birthCertificate): bool
    {
        return $user->hasPermissionTo('birth-certificate: read') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('birth-certificate: create') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BirthCertificate $birthCertificate): bool
    {
        return $user->hasPermissionTo('birth-certificate: update') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BirthCertificate $birthCertificate): bool
    {
        return $user->hasPermissionTo('birth-certificate: delete') ? true : false;
    }
}
