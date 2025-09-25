<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Campaign;
use App\Models\Step;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StepsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Campaign::all()->each(function ($campaign) {
            Step::factory()
                ->count(5)
                ->create(['campaign_id' => $campaign->id]);
        });
    }
}
