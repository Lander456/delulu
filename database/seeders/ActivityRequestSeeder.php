<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivityRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $requestor = User::where('username', 'requestor')->firstOrFail();

        for ($i = 0; $i < 5; $i++) {
            ActivityRequest::factory()->create([
                'user_id' => $requestor->id,
            ]);
        }
    }
}
