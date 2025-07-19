<?php

namespace App\Policies;

use App\Models\CoverLetter;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CoverLetterPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('cover-letter: menu') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CoverLetter $coverLetter): bool
    {
        return $user->hasPermissionTo('cover-letter: read') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('cover-letter: create') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CoverLetter $coverLetter): bool
    {
        return $user->hasPermissionTo('cover-letter: update') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CoverLetter $coverLetter): bool
    {
        return $user->hasPermissionTo('cover-letter: delete') ? true : false;
    }
}
