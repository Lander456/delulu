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

        $userIDs = User::all()->pluck('id');

        Step::all()->each(function (Step $step) use ($userIDs) {
            Activity::factory(rand(1, 5))
                ->create(['step_id' => $step->id])
                ->each (function (Activity $activity) use ($userIDs) {
                    $activity->users()->attach(
                        $userIDs->random(rand(0, 5))->toArray()
                    );
                });
        });
    }
}
