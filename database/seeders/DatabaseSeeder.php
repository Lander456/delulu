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
            UsersSeeder::class,
            ThemesSeeder::class,
            CampaignsSeeder::class,
            StepsSeeder::class,
            AreasOfInterestSeeder::class,
            InformationSourcesSeeder::class,
            //RolesAndPermissionsSeeder::class,
            TargetDemographicsSeeder::class,
            ActivitiesSeeder::class
        ]);
    }
}
