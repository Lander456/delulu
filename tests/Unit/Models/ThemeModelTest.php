<?php

namespace Tests\Unit\Models;

use App\Models\AreaOfInterest;
use App\Models\InformationSource;
use App\Models\TargetDemographic;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class ThemeModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_valid(): void
    {
        $user = User::inRandomOrder()->first();
        $theme = new Theme([
            'name' => 'testTheme',
            'description' => 'testThemeDescription',
            'user_id' => $user->id
        ]);

        $theme->save();

        $this->assertDatabaseHas('themes', [
            'name' => 'testTheme',
            'description' => 'testThemeDescription',
            'user_id' => $user->id
        ]);
    }

    public function test_create_without_name(): void
    {
        $this->expectException(QueryException::class);
        $user = User::inRandomOrder()->first();
        $theme = new Theme([
            'description' => 'testThemeDescription',
            'user_id' => $user->id
        ]);

        $theme->save();
    }

    public function test_create_without_description(): void
    {
        $user = User::inRandomOrder()->first();
        $theme = new Theme([
            'name' => 'testTheme',
            'user_id' => $user->id
        ]);

        $theme->save();

        $this->assertDatabaseHas('themes', [
            'name' => 'testTheme',
            'description' => null,
            'user_id' => $user->id
        ]);
    }

    public function test_create_without_user_id(): void
    {
        $this->expectException(QueryException::class);
        $theme = new Theme([
            'name' => 'testTheme',
            'description' => 'testThemeDescription',
        ]);

        $theme->save();
    }

    public function test_create_with_non_existent_user(): void
    {
        $this->expectException(QueryException::class);
        $user = User::factory()->make();
        $theme = new Theme([
            'name' => 'testTheme',
            'description' => 'testThemeDescription',
            'user_id' => $user->id
        ]);

        $theme->save();
    }

    public function test_attach_existing_area_of_interest(): void
    {
        $areaOfInterest = AreaOfInterest::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        $theme = Theme::factory()->create([
            'user_id' => $user->id,
        ]);

        $theme->areasOfInterest()->attach($areaOfInterest);

        $this->assertDatabaseHas('area_of_interest_theme', [
            'theme_id' => $theme->id,
            'area_of_interest_id' => $areaOfInterest->id
        ]);
    }

    public function test_attach_non_existing_area_of_interest(): void
    {
        $this->expectException(QueryException::class);
        $areaOfInterest = AreaOfInterest::factory()->make();
        $theme = Theme::factory()->create();

        $theme->areasOfInterest()->attach($areaOfInterest);
    }

    public function test_attach_existing_target_demographic(): void
    {
        $targetDemographic = TargetDemographic::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        $theme = Theme::factory()->create([
            'user_id' => $user->id,
        ]);

        $theme->targetDemographics()->attach($targetDemographic);

        $this->assertDatabaseHas('target_demographic_theme', [
            'target_demographic_id' => $targetDemographic->id,
            'theme_id' => $theme->id
        ]);
    }

    public function test_attach_non_existing_target_demographic(): void
    {
        $this->expectException(QueryException::class);
        $targetDemographic = TargetDemographic::factory()->make();
        $theme = Theme::factory()->create();

        $theme->targetDemographics()->attach($targetDemographic);
    }

    public function test_attach_existing_information_source(): void
    {
        $informationSource = InformationSource::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        $theme = Theme::factory()->create([
            'user_id' => $user->id,
        ]);

        $theme->informationSources()->attach($informationSource);

        $this->assertDatabaseHas('information_source_theme', [
            'information_source_id' => $informationSource->id,
            'theme_id' => $theme->id
        ]);
    }

    public function test_attach_non_existing_information_source(): void
    {
        $this->expectException(QueryException::class);
        $informationSource = InformationSource::factory()->make();
        $theme = Theme::factory()->create();

        $theme->informationSources()->attach($informationSource);
    }
}
