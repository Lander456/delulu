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


        /**
         *  Create predefinied system admin user
         */
        $adminUser = User::factory()
            ->create(
                ['password' => 'adminsecretpass', 
                             'email' => 'admindelulu@delulusys.com',
                             'username' => 'deluluadmin' 
                             ]
            );

        $adminUser->assignRole(RolesEnum::SYSADMIN->value);

        /**
         *  Seed random users
         */
        foreach (Role::all() as $role) {
            $users = User::factory(5)
                ->create(
                    ['password' => 'secretpass']
                );

            foreach ($users as $user) {
                $user->assignRole($role->name);
            }
        }

        
    }
}
