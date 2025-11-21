<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\Activity;
use App\Models\User;

class ActivityPolicy
{
    /**
     * System admin pass
     */
    public function before(User $user, $ability)
    {
        if ($user->hasRole(RolesEnum::SYSADMIN->value)) {
            return true; // admin bypasses all checks
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::VIEW_ACTIVITIES->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Activity $activity): bool
    {
        if ($activity->users->contains($user)) {
            return true;
        }

        return $user->id == $activity->step->user_id ||
            $user->id == $activity->step->campaign->user_id ||
            $user->id == $activity->step->campaign->theme->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::CREATE_ACTIVITIES->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Activity $activity): bool
    {
        
        $parentStep = $activity->step;

        return $parentStep->user->id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Activity $activity): bool
    {
        return $activity->step->user->id == $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Activity $activity): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Activity $activity): bool
    {
        return false;
    }

    public function administer(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::EDIT_ACTIVITIES->value);
    }
}
