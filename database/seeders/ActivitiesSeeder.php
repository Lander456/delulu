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

        Step::all()->each(function (Step $step) {
            Activity::factory()
                ->count(5)
                ->create(['step_id' => $step->id]);
        });
    }
}
