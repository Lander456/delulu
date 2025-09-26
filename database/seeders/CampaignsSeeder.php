<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampaignsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $themes = Theme::all();
        $users = User::all();

        foreach ($themes as $theme) {
            Campaign::factory(rand(1, 5))->create([
                'theme_id' => $theme->id,
                'user_id' => $users->random()->id
            ]);
        }
    }
}
