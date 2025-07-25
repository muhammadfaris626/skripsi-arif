<?php

namespace App\Policies;

use App\Models\DomicileCertificate;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DomicileCertificatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('domicile-certificate: menu') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DomicileCertificate $domicileCertificate): bool
    {
        return $user->hasPermissionTo('domicile-certificate: read') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('domicile-certificate: create') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DomicileCertificate $domicileCertificate): bool
    {
        return $user->hasPermissionTo('domicile-certificate: update') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DomicileCertificate $domicileCertificate): bool
    {
        return $user->hasPermissionTo('domicile-certificate: delete') ? true : false;
    }
}
