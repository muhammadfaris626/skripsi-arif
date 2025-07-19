<?php

namespace App\Policies;

use App\Models\CertificateCategory;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CertificateCategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('certificate-category: menu') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CertificateCategory $certificateCategory): bool
    {
        return $user->hasPermissionTo('certificate-category: read') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('certificate-category: create') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CertificateCategory $certificateCategory): bool
    {
        return $user->hasPermissionTo('certificate-category: update') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CertificateCategory $certificateCategory): bool
    {
        return $user->hasPermissionTo('certificate-category: delete') ? true : false;
    }
}
