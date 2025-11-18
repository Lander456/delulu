<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CampaignPolicy
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
        return $user->hasPermissionTo(PermissionsEnum::VIEW_CAMPAIGNS->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Campaign $campaign): bool
    {
        return $campaign->user->id == $user->id or
            $campaign->theme->user->id == $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::CREATE_CAMPAIGNS->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Campaign $campaign): bool
    {
        $parentTheme = $campaign->theme;

        return $campaign->user->id == $user->id or
            $parentTheme->user->id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Campaign $campaign): bool
    {
        $parentTheme = $campaign->theme;
        return $campaign->user->id == $user->id or
            $parentTheme->user->id == $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Campaign $campaign): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Campaign $campaign): bool
    {
        return false;
    }
}
