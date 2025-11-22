<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Seeder;

class CampaignUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $campaigns = Campaign::all();

        foreach($users as $user) {
            $assignedCampaigns = $campaigns->random()->pluck('id');
            $user->assignedCampaigns()->sync($assignedCampaigns);
        }
    }
}
