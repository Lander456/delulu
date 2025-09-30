<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
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

        $campaigns = Campaign::all();
        $users = User::role(RolesEnum::COORDINATOR->value)->get();

        foreach ($campaigns as $campaign) {
            Step::factory(rand(1, 4))
                ->create([
                    'campaign_id' => $campaign->id,
                    'user_id' => $users->random()->id
                ]);
        }
    }
}
