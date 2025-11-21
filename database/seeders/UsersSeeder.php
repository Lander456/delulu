<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

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

        

        $sysAdmin = User::factory()->create([
            'username' => 'sysadmin',
            'email' => 'sysadmin@example.com',
            'password' => bcrypt('sysadminpass')
        ]);
        $sysAdmin->assignRole('sysadmin');

        $themeAdmin = User::factory()->create([
            'username' => 'themeAdmin',
            'email' => 'themeAdmin@example.com',
            'password' => bcrypt('themeAdminpass')
        ]);
        $themeAdmin->assignRole('admin');

        $campaignLeader = User::factory()->create([
            'username' => 'campaignAdmin',
            'email' => 'campaignAdmin@example.com',
            'password' => bcrypt('campaignAdminpass')
        ]);
        $campaignLeader->assignRole('campaign_leader');

        $worker = User::factory()->create([
            'username' => 'worker',
            'email' => 'worker@example.com',
            'password' => bcrypt('workerpass')
        ]);
        $worker->assignRole('worker');

        $coordinator = User::factory()->create([
            'username' => 'coordinator',
            'email' => 'coordinator@example.com',
            'password' => bcrypt('coordinatorpass')
        ]);
        $coordinator->assignRole('coordinator');
    }
}
