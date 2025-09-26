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

        InformationSource::factory(5)
            ->create()
            ->each(function ($informationSource) use ($themeIDs) {
                $informationSource->themes()->attach(
                    $themeIDs->random(rand(1, 5))->toArray()
                );
            });
    }
}
