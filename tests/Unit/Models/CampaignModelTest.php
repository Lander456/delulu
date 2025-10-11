<?php

namespace Tests\Unit\Models;

use App\Models\Campaign;
use App\Models\Step;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CampaignModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_valid(): void
    {
        $user = User::inRandomOrder()->first();
        $theme = Theme::inRandomOrder()->first();
        $campaign = new Campaign([
            'name' => 'testCampaign',
            'description' => 'testCampaignDescription',
        ]);
        $campaign->theme()->associate($theme);
        $campaign->user()->associate($user);
        $this->assertTrue($campaign->save());
    }

    public function test_create_without_name(): void{
        $this->expectException(QueryException::class);
        $user = User::inRandomOrder()->first();
        $theme = Theme::inRandomOrder()->first();

        $campaign = new Campaign([
            'description' => 'testCampaignDescription',
        ]);
        $campaign->theme()->associate($theme);
        $campaign->user()->associate($user);

        $campaign->save();
    }

    public function test_create_without_description(): void
    {
        $user = User::inRandomOrder()->first();
        $theme = Theme::inRandomOrder()->first();

        $campaign = new Campaign([
            'name' => 'testCampaign'
        ]);
        $campaign->theme()->associate($theme);
        $campaign->user()->associate($user);
        $campaign->save();

        $this->assertDatabaseHas('campaigns', [
            'id' => $campaign->id,
            'name' => 'testCampaign'
        ]);
    }

    public function test_create_with_non_existing_user(): void
    {
        $this->expectException(QueryException::class);
        $user = User::factory()->make();
        $theme = Theme::inRandomOrder()->first();
        $campaign = new Campaign([
            'name' => 'testCampaign',
            'description' => 'testCampaignDescription',
        ]);

        $campaign->theme()->associate($theme);
        $campaign->user()->associate($user);

        $campaign->save();
    }

    public function test_create_with_non_existing_theme(): void
    {
        $this->expectException(QueryException::class);
        $user = User::inRandomOrder()->first();
        $theme = Theme::factory()->make();
        $campaign = new Campaign([
            'name' => 'testCampaign',
            'description' => 'testCampaignDescription',
        ]);

        $campaign->theme()->associate($theme);
        $campaign->user()->associate($user);

        $campaign->save();
    }

    public function test_assign_existing_step(): void
    {
        $step = Step::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        $theme = Theme::inRandomOrder()->first();
        $campaign = new Campaign([
            'name' => 'testCampaign',
            'description' => 'testCampaignDescription',
        ]);
        $campaign->theme()->associate($theme);
        $campaign->user()->associate($user);
        $campaign->save();

        $campaign->steps()->save($step);

        $this->assertDatabaseHas('steps', [
            'id' => $step->id,
            'campaign_id' => $campaign->id,
            'user_id' => $step->user->id,
            'name' => $step->name,
            'description' => $step->description,
        ]);
    }

    public function test_assign_non_existing_step(): void
    {
        $this->expectException(QueryException::class);
        $user = User::inRandomOrder()->first();
        $theme = Theme::inRandomOrder()->first();
        $campaign = new Campaign([
            'name' => 'testCampaign',
            'description' => 'testCampaignDescription'
        ]);
        $campaign->theme()->associate($theme);
        $campaign->user()->associate($user);
        $campaign->save();

        $step = Step::factory()->make();
        $campaign->steps()->save($step);
    }
}
