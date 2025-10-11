<?php

namespace Tests\Unit\Models;

use App\Models\InformationSource;
use App\Models\TargetDemographic;
use App\Models\Theme;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InformationSourceModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_valid(): void
    {
        $informationSource = new InformationSource([
            'name' => 'testInformationSource',
            'description' => 'testInformationSourceDescription',
        ]);
        $informationSource->save();

        $this->assertDatabaseHas('information_sources', [
            'name' => 'testInformationSource',
            'description' => 'testInformationSourceDescription',
        ]);
    }

    public function test_create_without_name(): void
    {
        $this->expectException(QueryException::class);
        $informationSource = new InformationSource([
            'description' => 'testInformationSourceDescription',
        ]);

        $this->assertFalse($informationSource->save());
    }

    public function test_create_without_description(): void
    {
        $informationSource = new InformationSource([
            'name' => 'testInformationSource',
        ]);
        $informationSource->save();

        $this->assertDatabaseHas('information_sources', [
            'name' => 'testInformationSource',
            'description' => null
        ]);
    }

    public function test_assign_existing_target_demographic(): void
    {
        $targetDemographic = TargetDemographic::inRandomOrder()->first();
        $informationSource = new InformationSource([
            'name' => 'testInformationSource',
            'description' => 'testInformationSourceDescription',
        ]);
        $informationSource->save();

        $informationSource->targetDemographics()->attach($targetDemographic);

        $this->assertDatabaseHas('IS_target_demographic', [
            'information_source_id' => $informationSource->id,
            'target_demographic_id' => $targetDemographic->id,
        ]);
    }

    public function test_assign_non_existing_target_demographic(): void
    {
        $this->expectException(QueryException::class);
        $targetDemographic = TargetDemographic::factory()->make();
        $informationSource = new InformationSource([
            'name' => 'testInformationSource',
            'description' => 'testInformationSourceDescription',
        ]);
        $informationSource->save();

        $informationSource->targetDemographics()->attach($targetDemographic);
    }

    public function test_assign_existing_theme(): void
    {
        $theme = Theme::inRandomOrder()->first();
        $informationSource = new InformationSource([
            'name' => 'testInformationSource',
            'description' => 'testInformationSourceDescription'
        ]);
        $informationSource->save();

        $informationSource->themes()->attach($theme);

        $this->assertDatabaseHas('information_source_theme', [
            'information_source_id' => $informationSource->id,
            'theme_id' => $theme->id
        ]);
    }

    public function test_assign_non_existing_theme(): void
    {
        $this->expectException(QueryException::class);
        $theme = Theme::factory()->make();
        $informationSource = new InformationSource([
            'name' => 'testInformationSource',
            'description' => 'testInformationSourceDescription'
        ]);
        $informationSource->save();

        $informationSource->themes()->attach($theme);
    }
}
