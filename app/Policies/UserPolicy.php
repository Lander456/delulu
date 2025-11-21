<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user is a sysadmin, thus having privileges to do anything
     */
    public function before(User $user): ?bool
    {
        if ($user->hasRole(RolesEnum::SYSADMIN->value))
        {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::CREATE_USERS->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $userModel): bool
    {
        return $user->id == $userModel->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::CREATE_USERS->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $userModel): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::EDIT_USERS->value) ||
            $user->id == $userModel->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $userModel): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::DELETE_USERS->value) ||
            $user->id == $userModel->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
