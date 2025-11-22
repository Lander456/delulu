<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Campaign;
use App\Models\Step;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activityNum = 0;

        $userIDs = User::all()->pluck('id');

        Step::all()->each(function (Step $step) use ($userIDs, &$activityNum) {

            $count = rand(1, 5);

            for ($i = 0; $i < $count; $i++) {

                $activity = Activity::factory()->create([
                    'name' => "Example Activity $activityNum",
                    'step_id' => $step->id
                ]);

                $activity->users()->attach($userIDs->random());

                $activityNum++;
            }
        });
    }
}
