<?php

namespace Tests\Unit\Models;

use App\Models\Activity;
use App\Models\Campaign;
use App\Models\Step;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StepModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_valid(): void
    {
        $user = User::inRandomOrder()->first();
        $campaign = Campaign::inRandomOrder()->first();
        $activity = Activity::inRandomOrder()->first();

        $step = new Step([
            'name' => 'testStep',
            'description' => 'testStepDescription',
            'campaign_id' => $campaign->id,
            'user_id' => $user->id
        ]);

        $step->save();
        $step->activities()->save($activity);

        $this->assertDatabaseHas('steps', [
            'id' => $step->id,
            'name' => 'testStep',
            'description' => 'testStepDescription',
            'campaign_id' => $campaign->id,
            'user_id' => $user->id
        ]);
    }

    public function test_create_without_name(): void
    {
        $this->expectException(QueryException::class);
        $user = User::inRandomOrder()->first();
        $campaign = Campaign::inRandomOrder()->first();
        $activity = Activity::inRandomOrder()->first();

        $step = new Step([
            'description' => 'testStepDescription',
            'campaign_id' => $campaign->id,
            'user_id' => $user->id
        ]);

        $step->save();
        $step->activities()->save($activity);
    }

    public function test_create_without_description(): void
    {
        $user = User::inRandomOrder()->first();
        $campaign = Campaign::inRandomOrder()->first();
        $activity = Activity::inRandomOrder()->first();

        $step = new Step([
            'name' => 'testStep',
            'campaign_id' => $campaign->id,
            'user_id' => $user->id,
        ]);
        $step->save();
        $step->activities()->save($activity);

        $this->assertDatabaseHas('steps', [
            'id' => $step->id,
            'name' => 'testStep',
            'description' => null,
            'campaign_id' => $campaign->id,
            'user_id' => $user->id
        ]);
    }

    public function test_create_without_user_id(): void
    {
        $this->expectException(QueryException::class);
        $campaign = Campaign::inRandomOrder()->first();
        $activity = Activity::inRandomOrder()->first();

        $step = new Step([
            'name' => 'testStep',
            'description' => 'testStepDescription',
            'campaign_id' => $campaign->id
        ]);

        $step->save();
        $step->activities()->save($activity);
    }

    public function test_create_without_campaign_id(): void
    {
        $this->expectException(QueryException::class);
        $user = User::inRandomOrder()->first();
        $activity = Activity::inRandomOrder()->first();

        $step = new Step([
            'name' => 'testStep',
            'description' => 'testStepDescription',
            'user_id' => $user->id
        ]);

        $step->save();
        $step->activities()->save($activity);
    }

    public function test_create_with_non_existing_user(): void
    {
        $this->expectException(QueryException::class);
        $user = User::factory()->make();
        $campaign = Campaign::inRandomOrder()->first();
        $activity = Activity::inRandomOrder()->first();

        $step = new Step([
            'name' => 'testStep',
            'description' => 'testStepDescription',
            'user_id' => $user->id,
            'campaign_id' => $campaign->id
        ]);

        $step->save();
        $step->activities()->save($activity);
    }

    public function test_create_with_non_existing_campaign(): void
    {
        $this->expectException(QueryException::class);
        $user = User::inRandomOrder()->first();
        $campaign = Campaign::factory()->make();
        $activity = Activity::inRandomOrder()->first();

        $step = new Step([
            'name' => 'testStep',
            'description' => 'testStepDescription',
            'user_id' => $user->id,
            'campaign_id' => $campaign->id
        ]);

        $step->save();
        $step->activities()->save($activity);
    }
}
