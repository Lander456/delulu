<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\Step;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StepPolicy
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
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::VIEW_STEPS->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Step $step): bool
    {
        if ($step->user_id === $user->id) {
            return true;
        }

        if ($step->campaign && $step->campaign->user_id === $user->id) {
            return true;
        }
        if ($step->activities()->whereHas('users', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })->exists()) {
            return true; 
        }

        if ($step->campaign && $step->campaign->theme && $step->campaign->theme->user_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::CREATE_STEPS->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Step $step): bool
    {
        return $step->user->id == $user->id or
            $step->campaign->user->id == $user->id or
            $step->campaign->theme->user->id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Step $step): bool
    {
        if ($user->hasPermissionTo(PermissionsEnum::DELETE_STEPS->value)) {

            if ($step->campaign->user->id == $user->id) {
                return true;
            }

            if ($step->campaign->theme->user->id == $user->id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Step $step): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Step $step): bool
    {
        return false;
    }

    public function administer(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::EDIT_STEPS->value);
    }
}
