<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThemesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::role(RolesEnum::ADMIN->value)->get();

        foreach ($users as $user) {
            Theme::factory(5)
                ->create([
                    'user_id' => $user->id,
                ]);
        }
    }
}
