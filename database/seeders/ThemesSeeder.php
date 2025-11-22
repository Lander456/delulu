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

        $themeNum = 0;
        foreach ($users as $user) {
            Theme::factory()
                ->create([
                    'name' => "Example Theme $themeNum",
                    'user_id' => $user->id,
                ]);
            $themeNum++;
        }
    }
}
