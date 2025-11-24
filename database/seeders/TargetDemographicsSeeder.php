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
        $targetDemographicNum = 0;

        for ($i = 1; $i <= 5; $i++) {
            $targetDemographic = TargetDemographic::factory()->create([
                'name' => "Example target demographic $targetDemographicNum",
            ]);

            $targetDemographic->themes()->attach($themeIDs->random());
            $targetDemographic->informationSources()->attach($informationSourceIDs->random());
            $targetDemographic->areasOfInterest()->attach($areaOfInterestIDs->random());
            $targetDemographic->users()->attach($userIDs->random());

            $targetDemographicNum++;
        }
    }
}
