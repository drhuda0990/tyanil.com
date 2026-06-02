<?php

namespace App\Policies;

use App\StoreNotification;
use App\User;

class StoreNotificationPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, StoreNotification $storeNotification): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, StoreNotification $storeNotification): bool
    {
        return true;
    }

    public function delete(User $user, StoreNotification $storeNotification): bool
    {
        return true;
    }

    public function restore(User $user, StoreNotification $storeNotification): bool
    {
        return true;
    }

    public function forceDelete(User $user, StoreNotification $storeNotification): bool
    {
        return true;
    }
}
