<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
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
        $users = User::role(RolesEnum::CAMPAIGN_LEADER->value)->get();

        foreach ($themes as $theme) {
            foreach ($users as $user) {
                Campaign::factory(rand(1, 4))->create([
                    'theme_id' => $theme->id,
                    'user_id' => $user->id
                ]);
            }
        }
    }
}
