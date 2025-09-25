<?php

namespace Database\Seeders;

use App\Models\TargetDemographic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TargetDemographicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TargetDemographic::factory()->count(5)->create();
    }
}
