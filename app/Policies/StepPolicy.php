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
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::VIEW_STEPS->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::VIEW_STEPS->value);
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
        return $user->getKey() == $step->user()->first()->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Step $step): bool
    {
        return $user->getKey() == $step->user()->first()->id;
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
}
