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
        $stepNum = 0;

        foreach ($campaigns as $campaign) {
            foreach ($users as $user) {
                $count = rand(1, 5);

                for ($i = 0; $i < $count; $i++) {
                    $maxOrder = $campaign->steps()->max('order') ?? 0;
                    Step::factory()
                        ->create([
                            'name' => "Example Step $stepNum",
                            'campaign_id' => $campaign->id,
                            'user_id' => $user->id,
                            'order' => $maxOrder + 1
                        ]);
                    $stepNum++;
                }
                $campaign->update(['current_step_id' => $campaign->steps()->first()->id]);
            }
        }
    }
}
