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

        $sysAdmin = User::factory()->create([
            'username' => 'sysadmin',
            'email' => 'sysadmin@example.com',
            'password' => bcrypt('sysadminpass')
        ]);
        $sysAdmin->assignRole(RolesEnum::SYSADMIN->value);

        $themeAdmin = User::factory()->create([
            'username' => 'themeAdmin',
            'email' => 'themeAdmin@example.com',
            'password' => bcrypt('themeAdminpass')
        ]);
        $themeAdmin->assignRole(RolesEnum::ADMIN->value);

        $campaignLeader = User::factory()->create([
            'username' => 'campaignAdmin',
            'email' => 'campaignAdmin@example.com',
            'password' => bcrypt('campaignAdminpass')
        ]);
        $campaignLeader->assignRole(RolesEnum::CAMPAIGN_LEADER->value);

        $worker = User::factory()->create([
            'username' => 'worker',
            'email' => 'worker@example.com',
            'password' => bcrypt('workerpass')
        ]);
        $worker->assignRole(RolesEnum::WORKER->value);

        $coordinator = User::factory()->create([
            'username' => 'coordinator',
            'email' => 'coordinator@example.com',
            'password' => bcrypt('coordinatorpass')
        ]);
        $coordinator->assignRole(RolesEnum::COORDINATOR->value);

        $requestor = User::factory()->create([
            'username' => 'requestor',
            'email' => 'requestor@example.com',
            'password' => bcrypt('requestorpass')
        ]);
        $requestor->assignRole(RolesEnum::WORKER->value);
    }
}
