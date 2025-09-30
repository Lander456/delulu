<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\Activity;
use App\Models\Campaign;
use App\Models\Step;
use App\Models\User;

class ActivityPolicy
{
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
    public function view(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::VIEW_ACTIVITIES->value);
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
        $parentCampaign = $parentStep->campaign;
        $parentTheme = $parentCampaign->theme;

        return $parentStep->user->id == $user->id or
            $parentCampaign->user->id == $user->id or
            $parentTheme->user->id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Activity $activity): bool
    {
        $parentStep = $activity->step;
        $parentCampaign = $parentStep->campaign;
        $parentTheme = $parentCampaign->theme;

        return $parentStep->user->id == $user->id or
            $parentCampaign->user->id == $user->id or
            $parentTheme->user->id == $user->id;
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
}
