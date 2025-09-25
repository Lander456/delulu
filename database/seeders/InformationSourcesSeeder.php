<?php

namespace Database\Seeders;

use App\Models\InformationSource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InformationSourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InformationSource::factory()->count(5)->create();
    }
}
