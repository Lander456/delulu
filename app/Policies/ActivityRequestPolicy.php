<?php

namespace App\Policies;

use App\Enums\RolesEnum;
use App\Models\ActivityRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ActivityRequestPolicy
{
    /**
     * Determine whether the user is a sysadmin, thus having privileges to do anything
     */
    public function before(User $user): ?bool
    {
        if ($user->hasRole(RolesEnum::SYSADMIN->value)) {
            return true; // admin bypasses all checks
        }

        return null;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ActivityRequest $activityRequest): bool
    {
        return $user->id === $activityRequest->user_id ||
            $user->id === $user->hasRole(RolesEnum::COORDINATOR->value) ||
            $activityRequest->activity->step->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ActivityRequest $activityRequest): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ActivityRequest $activityRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ActivityRequest $activityRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ActivityRequest $activityRequest): bool
    {
        return false;
    }
}
