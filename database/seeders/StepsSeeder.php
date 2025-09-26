<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Campaign;
use App\Models\Step;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StepsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $campaignIDs = Campaign::all()->pluck('id');
        $userIDs = User::all()->pluck('id');

        foreach ($campaignIDs as $campaignID) {
            Step::factory(rand(1, 5))
                ->create([
                    'campaign_id' => $campaignID,
                    'user_id' => $userIDs->random()
                ]);
        }
    }
}
