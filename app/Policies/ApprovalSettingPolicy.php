<?php

namespace App\Policies;

use App\Models\ApprovalSetting;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ApprovalSettingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('approval-setting: menu') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ApprovalSetting $approvalSetting): bool
    {
        return $user->hasPermissionTo('approval-setting: read') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('approval-setting: create') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ApprovalSetting $approvalSetting): bool
    {
        return $user->hasPermissionTo('approval-setting: update') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ApprovalSetting $approvalSetting): bool
    {
        return $user->hasPermissionTo('approval-setting: delete') ? true : false;
    }
}
