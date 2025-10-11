<?php

namespace Tests\Unit\Models;

use App\Models\AreaOfInterest;
use App\Models\InformationSource;
use App\Models\TargetDemographic;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TargetDemographicModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_valid(): void
    {
        $targetDemographic = new TargetDemographic([
            'name' => 'testTargetDemographic',
            'description' => 'testTargetDemographicDescription',
            'amount' => 100,
            'difficulty' => 0.9,
            'ethics' => 'pretty ethical IMO',
            'relevance' => 0.1
        ]);

        $targetDemographic->save();

        $this->assertDatabaseHas('target_demographics', [
            'name' => 'testTargetDemographic',
            'description' => 'testTargetDemographicDescription',
            'amount' => 100,
            'difficulty' => 0.9,
            'ethics' => 'pretty ethical IMO',
            'relevance' => 0.1
        ]);
    }

    public function test_create_without_name(): void
    {
        $this->expectException(QueryException::class);
        $targetDemographic = new TargetDemographic([
            'description' => 'testTargetDemographicDescription',
            'amount' => 100,
            'difficulty' => 0.9,
            'ethics' => 'pretty ethical IMO',
            'relevance' => 0.1
        ]);

        $targetDemographic->save();
    }

    public function create_without_description(): void
    {
        $targetDemographic = new TargetDemographic([
            'name' => 'testTargetDemographic',
            'amount' => 100,
            'difficulty' => 0.9,
            'ethics' => 'pretty ethical IMO',
            'relevance' => 0.1
        ]);

        $targetDemographic->save();

        $this->assertDatabaseHas('target_demographics', [
            'name' => 'testTargetDemographic',
            'amount' => 100,
            'difficulty' => 0.9,
            'ethics' => 'pretty ethical IMO',
            'relevance' => 0.1
        ]);
    }

    public function test_create_without_amount(): void
    {
        $targetDemographic = new TargetDemographic([
            'name' => 'testTargetDemographic',
            'description' => 'testTargetDemographicDescription',
            'difficulty' => 0.9,
            'ethics' => 'pretty ethical IMO',
            'relevance' => 0.1
        ]);

        $targetDemographic->save();

        $this->assertDatabaseHas('target_demographics', [
            'name' => 'testTargetDemographic',
            'description' => 'testTargetDemographicDescription',
            'amount' => 0,
            'difficulty' => 0.9,
            'ethics' => 'pretty ethical IMO',
            'relevance' => 0.1
        ]);
    }

    public function test_create_without_difficulty(): void
    {
        $targetDemographic = new TargetDemographic([
            'name' => 'testTargetDemographic',
            'description' => 'testTargetDemographicDescription',
            'amount' => 100,
            'ethics' => 'pretty ethical IMO',
            'relevance' => 0.1
        ]);

        $targetDemographic->save();

        $this->assertDatabaseHas('target_demographics', [
            'name' => 'testTargetDemographic',
            'description' => 'testTargetDemographicDescription',
            'amount' => 100,
            'difficulty' => 0,
            'ethics' => 'pretty ethical IMO',
            'relevance' => 0.1
        ]);
    }

    public function test_create_without_ethics(): void
    {
        $targetDemographic = new TargetDemographic([
            'name' => 'testTargetDemographic',
            'description' => 'testTargetDemographicDescription',
            'amount' => 100,
            'difficulty' => 0.9,
            'relevance' => 0.1
        ]);

        $targetDemographic->save();

        $this->assertDatabaseHas('target_demographics', [
            'name' => 'testTargetDemographic',
            'description' => 'testTargetDemographicDescription',
            'amount' => 100,
            'difficulty' => 0.9,
            'ethics' => null,
            'relevance' => 0.1
        ]);
    }

    public function test_create_without_relevance(): void
    {
        $targetDemographic = new TargetDemographic([
            'name' => 'testTargetDemographic',
            'description' => 'testTargetDemographicDescription',
            'amount' => 100,
            'difficulty' => 0.9,
            'ethics' => 'pretty ethical IMO',
        ]);

        $targetDemographic->save();

        $this->assertDatabaseHas('target_demographics', [
            'name' => 'testTargetDemographic',
            'description' => 'testTargetDemographicDescription',
            'amount' => 100,
            'difficulty' => 0.9,
            'ethics' => 'pretty ethical IMO',
        ]);
    }

    public function test_assign_existing_user(): void
    {
        $targetDemographic = TargetDemographic::factory()->create();
        $user = User::inRandomOrder()->first();

        $targetDemographic->users()->attach($user);

        $this->assertDatabaseHas('target_demographic_user', [
            'user_id' => $user->id,
            'target_demographic_id' => $targetDemographic->id
        ]);
    }

    public function test_assign_non_existing_user(): void
    {
        $this->expectException(QueryException::class);
        $targetDemographic = TargetDemographic::factory()->create();
        $user = User::factory()->make();

        $targetDemographic->users()->attach($user);
    }

    public function test_assign_existing_area_of_interest(): void
    {
        $targetDemographic = TargetDemographic::factory()->create();
        $areaOfInterest = AreaOfInterest::inRandomOrder()->first();

        $targetDemographic->areasOfInterest()->attach($areaOfInterest);

        $this->assertDatabaseHas('AOI_target_demographic', [
            'area_of_interest_id' => $areaOfInterest->id,
            'target_demographic_id' => $targetDemographic->id
        ]);
    }

    public function test_assign_non_existing_area_of_interest(): void
    {
        $this->expectException(QueryException::class);
        $targetDemographic = TargetDemographic::factory()->create();
        $areaOfInterest = AreaOfInterest::factory()->make();

        $targetDemographic->areasOfInterest()->attach($areaOfInterest);
    }

    public function test_assign_existing_theme(): void
    {
        $targetDemographic = TargetDemographic::factory()->create();
        $theme = Theme::inRandomOrder()->first();

        $targetDemographic->themes()->attach($theme);

        $this->assertDatabaseHas('target_demographic_theme', [
            'theme_id' => $theme->id,
            'target_demographic_id' => $targetDemographic->id
        ]);
    }

    public function test_assign_non_existing_theme(): void
    {
        $this->expectException(QueryException::class);
        $targetDemographic = TargetDemographic::factory()->create();
        $theme = Theme::factory()->make();

        $targetDemographic->themes()->attach($theme);
    }

    public function test_assign_existing_information_source(): void
    {
        $targetDemographic = TargetDemographic::factory()->create();
        $informationSource = InformationSource::inRandomOrder()->first();

        $targetDemographic->informationSources()->attach($informationSource);

        $this->assertDatabaseHas('IS_target_demographic', [
            'information_source_id' => $informationSource->id,
            'target_demographic_id' => $targetDemographic->id
        ]);
    }

    public function test_assign_non_existing_information_source(): void
    {
        $this->expectException(QueryException::class);
        $targetDemographic = TargetDemographic::factory()->create();
        $informationSource = InformationSource::factory()->make();

        $targetDemographic->informationSources()->attach($informationSource);
    }
}
