<?php

namespace Database\Seeders;

use App\Models\AreaOfInterest;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreasOfInterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $userIDs = User::all()->pluck('id');
        $themeIDs = Theme::all()->pluck('id');

        AreaOfInterest::factory(5)
            ->create()
            ->each(function (AreaOfInterest $areaOfInterest) use ($userIDs, $themeIDs) {
                $areaOfInterest->users()->attach(
                    $userIDs->random(rand(0, 5))->toArray()
                );
                $areaOfInterest->themes()->attach(
                    $themeIDs->random(rand(1, 5))->toArray()
                );
            });
    }
}
