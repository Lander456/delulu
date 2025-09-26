<?php

namespace Database\Seeders;

use App\Models\AreaOfInterest;
use App\Models\InformationSource;
use App\Models\TargetDemographic;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TargetDemographicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $areaOfInterestIDs = AreaOfInterest::all()->pluck('id');
        $themeIDs = Theme::all()->pluck('id');
        $informationSourceIDs = InformationSource::all()->pluck('id');
        $userIDs = User::all()->pluck('id');

        TargetDemographic::factory(5)
            ->create()
            ->each(function (TargetDemographic $targetDemographic) use ($areaOfInterestIDs, $themeIDs, $informationSourceIDs, $userIDs) {
                $targetDemographic->areasOfInterest()->attach(
                    $areaOfInterestIDs->random(rand(0, 5))->toArray()
                );
                $targetDemographic->themes()->attach(
                    $themeIDs->random(rand(1, 5))->toArray()
                );
                $targetDemographic->informationSources()->attach(
                    $informationSourceIDs->random(rand(0, 5))->toArray()
                );
                $targetDemographic->users()->attach(
                    $userIDs->random(rand(0, 5))->toArray()
                );
            });
    }
}
