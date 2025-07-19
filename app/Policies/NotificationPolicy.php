<?php

namespace App\Policies;

use App\Models\User;

class NotificationPolicy
{
    public function viewAny(User $user): bool {
        return $user->hasPermissionTo('notification: menu') ? true : false;
    }
}
