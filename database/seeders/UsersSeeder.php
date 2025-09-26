<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        foreach (Role::all() as $role) {
            $user = User::factory()
                ->create();

            $user->assignRole($role->name);
        }
    }
}
