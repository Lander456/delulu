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
            foreach ($users as $user) {
                $maxOrder = $campaign->steps()->max('order') ?? 0;
                Step::factory(1)
                    ->create([
                        'campaign_id' => $campaign->id,
                        'user_id' => $user->id,
                        'order' => $maxOrder + 1
                    ]);
                $campaign->update(['current_step_id' => $campaign->steps()->first()->id]);
            }
        }
    }
}
