<?php

namespace Database\Seeders;

use App\Models\InformationSource;
use App\Models\Theme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InformationSourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $themeIDs = Theme::all()->pluck('id');
        $informationSourceNum = 0;

        for ($i = 0; $i < 5; $i++) {
            $informationSource = InformationSource::factory()->create([
                'name' => "Example information source $informationSourceNum"
            ]);

            $informationSource->themes()->attach($themeIDs->random());

            $informationSourceNum++;
        }
    }
}
