<?php

namespace Database\Seeders;

use App\Models\AreaOfInterest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreasOfInterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AreaOfInterest::factory()->count(5)->create();
    }
}
