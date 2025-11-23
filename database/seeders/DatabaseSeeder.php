<?php

namespace Database\Seeders;

use App\Models\AreaOfInterest;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

            PermissionsSeeder::class,
            RolesSeeder::class,
            UsersSeeder::class,
            ThemesSeeder::class,
            CampaignsSeeder::class,
            StepsSeeder::class,
            ActivitiesSeeder::class,
            AreasOfInterestSeeder::class,
            InformationSourcesSeeder::class,
            TargetDemographicsSeeder::class,
            CampaignUserSeeder::class,
            ActivityRequestSeeder::class
        ]);
    }
}
