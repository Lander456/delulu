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

                    $createdRole->givePermissionTo([
                        PermissionsEnum::CREATE_THEMES->value,
                        PermissionsEnum::EDIT_THEMES->value,
                        PermissionsEnum::DELETE_THEMES->value,
                        PermissionsEnum::CREATE_USERS->value,
                        PermissionsEnum::EDIT_USERS->value,
                        PermissionsEnum::DELETE_USERS->value,
                        PermissionsEnum::ASSIGN_LEADERS->value
                        ]);
                    break;
                case RolesEnum::CAMPAIGN_LEADER->value:

                    $createdRole->givePermissionTo([
                        PermissionsEnum::CREATE_CAMPAIGNS->value,
                        PermissionsEnum::EDIT_CAMPAIGNS->value,
                        PermissionsEnum::DELETE_CAMPAIGNS->value,
                        PermissionsEnum::ASSIGN_COORDINATORS->value,
                        PermissionsEnum::CREATE_STEPS->value,
                        PermissionsEnum::EDIT_STEPS->value,
                        PermissionsEnum::DELETE_STEPS->value,
                    ]);
                    break;
                case RolesEnum::COORDINATOR->value:

                    $createdRole->givePermissionTo([
                        PermissionsEnum::ASSIGN_WORKERS->value,
                        PermissionsEnum::APPROVE_WORKERS->value,
                        PermissionsEnum::VIEW_ASSIGNED_WORKERS->value,
                        PermissionsEnum::CREATE_ACTIVITIES->value,
                        PermissionsEnum::EDIT_ACTIVITIES->value,
                        PermissionsEnum::DELETE_ACTIVITIES->value,
                    ]);
                    break;

                default:
                    break;


            }
        }
    }
}
