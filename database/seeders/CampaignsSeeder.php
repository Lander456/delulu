<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Theme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampaignsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Theme::all()->each(function (Theme $theme) {
            Campaign::factory()
                ->count(5)
                ->create(['theme_id' => $theme->id]);
        });
    }
}
