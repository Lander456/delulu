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
            ActivitiesSeeder::class,
            AreasOfInterestSeeder::class,
            CampaignsSeeder::class,
            InformationSourcesSeeder::class,
            //RolesAndPermissionsSeeder::class,
            StepsSeeder::class,
            TargetDemographicsSeeder::class,
            ThemesSeeder::class,
            UsersSeeder::class
        ]);
    }
}
