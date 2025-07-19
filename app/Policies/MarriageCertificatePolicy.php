<?php

namespace App\Policies;

use App\Models\MarriageCertificate;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MarriageCertificatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('marriage-certificate: menu') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MarriageCertificate $marriageCertificate): bool
    {
        return $user->hasPermissionTo('marriage-certificate: read') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('marriage-certificate: create') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MarriageCertificate $marriageCertificate): bool
    {
        return $user->hasPermissionTo('marriage-certificate: update') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MarriageCertificate $marriageCertificate): bool
    {
        return $user->hasPermissionTo('marriage-certificate: delete') ? true : false;
    }
}
