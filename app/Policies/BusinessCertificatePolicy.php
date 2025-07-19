<?php

namespace App\Policies;

use App\Models\BusinessCertificate;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BusinessCertificatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('business-certificate: menu') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BusinessCertificate $businessCertificate): bool
    {
        return $user->hasPermissionTo('business-certificate: read') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('business-certificate: create') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BusinessCertificate $businessCertificate): bool
    {
        return $user->hasPermissionTo('business-certificate: update') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BusinessCertificate $businessCertificate): bool
    {
        return $user->hasPermissionTo('business-certificate: delete') ? true : false;
    }
}
