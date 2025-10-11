<?php

namespace Tests\Unit\Models;

use App\Models\AreaOfInterest;
use App\Models\TargetDemographic;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class AreaOfInterestModelTest extends TestCase
{
    public function test_create_valid(): void
    {
        $areaOfInterest = new AreaOfInterest([
            'name' => 'TestAreaOfInterest',
            'description' => 'TestAreaOfInterestDescription',
            'relevance' => 100,
        ]);
        $this->assertTrue($areaOfInterest->save());
    }

    public function test_create_without_name(): void
    {
        $this->expectException(QueryException::class);

        $areaOfInterest = new AreaOfInterest([
            'description' => 'TestAreaOfInterestDescription',
            'relevance' => 100,
        ]);
        $areaOfInterest->save();
    }

    public function test_create_without_description(): void
    {
        $areaOfInterest = new AreaOfInterest([
            'name' => 'TestAreaOfInterest',
            'relevance' => 100,
        ]);
        $this->assertTrue($areaOfInterest->save());
    }

    public function test_create_without_relevance(): void
    {
        $areaOfInterest = new AreaOfInterest([
            'name' => 'TestAreaOfInterest',
            'description' => 'TestAreaOfInterestDescription',
        ]);
        $this->assertTrue($areaOfInterest->save());
    }

    public function test_assign_existing_user(): void
    {
        $user = User::inRandomOrder()->first();
        $areaOfInterest = new AreaOfInterest([
            'name' => 'TestAreaOfInterest',
            'description' => 'TestAreaOfInterestDescription',
            'relevance' => 100,
        ]);
        $areaOfInterest->save();
        $areaOfInterest->users()->attach($user);

        $this->assertDatabaseHas('area_of_interest_user',
            [
            'user_id' => $user->id,
            'area_of_interest_id' => $areaOfInterest->id
        ]);
    }

    public function test_assign_non_existing_user(): void
    {
        $this->expectException(QueryException::class);

        $user = User::factory()->make();
        $areaOfInterest = new AreaOfInterest([
            'name' => 'TestAreaOfInterest',
            'description' => 'TestAreaOfInterestDescription',
            'relevance' => 100,
        ]);

        $areaOfInterest->save();
        $areaOfInterest->users()->attach($user);
    }

    public function test_assign_existing_theme(): void
    {
        $theme = Theme::inRandomOrder()->first();

        $areaOfInterest = new AreaOfInterest([
            'name' => 'TestAreaOfInterest',
            'description' => 'TestAreaOfInterestDescription',
            'relevance' => 100
        ]);

        $areaOfInterest->save();
        $areaOfInterest->themes()->attach($theme);

        $this->assertDatabaseHas('area_of_interest_theme', [
            'theme_id' => $theme->id,
            'area_of_interest_id' => $areaOfInterest->id
        ]);
    }

    public function test_assign_non_existing_theme(): void
    {
        $this->expectException(QueryException::class);
        $theme = Theme::factory()->make();

        $areaOfInterest = new AreaOfInterest([
            'name' => 'TestAreaOfInterest',
            'description' => 'TestAreaOfInterestDescription',
            'relevance' => 100
        ]);

        $areaOfInterest->save();
        $areaOfInterest->themes()->attach($theme);
    }

    public function test_assign_existing_target_demographic(): void
    {
        $targetDemographic = TargetDemographic::inRandomOrder()->first();

        $areaOfInterest = new AreaOfInterest([
            'name' => 'TestAreaOfInterest',
            'description' => 'TestAreaOfInterestDescription',
            'relevance' => 100
        ]);
        $areaOfInterest->save();
        $areaOfInterest->targetDemographics()->attach($targetDemographic);

        $this->assertDatabaseHas('AOI_target_demographic', [
            'target_demographic_id' => $targetDemographic->id,
            'area_of_interest_id' => $areaOfInterest->id
        ]);
    }

    public function test_assign_non_existing_target_demographic(): void
    {
        $this->expectException(QueryException::class);
        $targetDemographic = TargetDemographic::factory()->make();

        $areaOfInterest = new AreaOfInterest([
            'name' => 'TestAreaOfInterest',
            'description' => 'TestAreaOfInterestDescription',
            'relevance' => 100
        ]);

        $areaOfInterest->targetDemographics()->attach($targetDemographic);
        $areaOfInterest->save();
    }
}
