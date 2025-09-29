<?php

namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        foreach( RolesEnum::cases() as $role ) {
            $createdRole = Role::create(['name' => $role->value]);

            switch( $createdRole->name ) {

                case RolesEnum::ADMIN->value:

                    $createdRole->givePermissionTo(PermissionsEnum::getThemesPerms());
                    $createdRole->givePermissionTo(PermissionsEnum::getUsersPerms());
                    $createdRole->givePermissionTo(PermissionsEnum::getAreasOfInterestPerms());
                    $createdRole->givePermissionTo(PermissionsEnum::getDemographicPerms());

                    $createdRole->givePermissionTo([
                        PermissionsEnum::ASSIGN_LEADERS->value,
                        ]);
                    break;
                case RolesEnum::CAMPAIGN_LEADER->value:

                    $createdRole->givePermissionTo(PermissionsEnum::getCampaignsPerms());
                    $createdRole->givePermissionTo(PermissionsEnum::getStepsPerms());
                    $createdRole->givePermissionTo([
                        PermissionsEnum::ASSIGN_COORDINATORS->value,
                    ]);
                    break;
                case RolesEnum::COORDINATOR->value:

                    $createdRole->givePermissionTo(PermissionsEnum::getActivitiesPerms());
                    $createdRole->givePermissionTo([
                        PermissionsEnum::ASSIGN_WORKERS->value,
                        PermissionsEnum::APPROVE_WORKERS->value,
                        PermissionsEnum::VIEW_ASSIGNED_WORKERS->value,
                    ]);
                    break;

                default:
                    break;


            }
        }
    }
}
