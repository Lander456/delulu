<?php

namespace Tests\Unit\Models;

use App\Models\Activity;
use App\Models\Step;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityModelTest extends TestCase
{

    use RefreshDatabase;

    public function test_create_valid(): void
    {
        $step = Step::inRandomOrder()->first();
        $activity = new Activity([
            'name' => 'Test Activity',
            'description' => 'Test Activity Description',
            'success' => 0.5,
        ]);
        $activity->step()->associate($step);
        $activity->save();

        $this->assertDatabaseHas('activities', [
            'name' => $activity->name,
            'description' => $activity->description,
            'success' => $activity->success,]);
    }

    public function test_create_without_args(): void
    {
        $this->expectException(QueryException::class);

        Activity::create();
    }

    public function test_create_without_name(): void
    {
        $this->expectException(QueryException::class);

        $step = Step::inRandomOrder()->first();
        $activity = new Activity([
            'description' => 'Test Activity Description',
            'success' => 0.5,
        ]);
        $activity->step()->associate($step);
        $activity->save();
    }

    public function test_create_without_description(): void
    {
        $step = Step::inRandomOrder()->first();
        $activity = new Activity([
            'name' => 'Test Activity',
            'success' => 0.5,
        ]);
        $activity->step()->associate($step);
        $activity->save();

        $this->assertDatabaseHas('activities', [
            'name' => $activity->name,
            'success' => $activity->success,
            'step_id' => $activity->step_id,
        ]);
    }

    public function test_create_without_success(): void
    {
        $step = Step::inRandomOrder()->first();
        $activity = new Activity([
            'name' => 'Test Activity',
            'description' => 'Test Activity Description'
        ]);
        $activity->step()->associate($step);
        $activity->save();

        $this->assertDatabaseHas('activities', [
            'name' => $activity->name,
            'description' => $activity->description,
            'success' => $activity->success,
            'step_id' => $activity->step_id,
        ]);
    }

    public function test_create_without_step_id(): void
    {
        $this->expectException(QueryException::class);

        $activity = new Activity([
            'name' => 'Test Activity',
            'description' => 'Test Activity Description',
            'success' => 0.5
        ]);
        $activity->save();
    }

    public function test_create_for_nonexistent_step(): void
    {
        $this->expectException(QueryException::class);

        $step = Step::factory()->make();
        $activity = new Activity([
            'name' => 'Test Activity',
            'description' => 'Test Activity Description',
            'success' => 0.5,
        ]);
        $activity->step()->associate($step);
        $activity->save();
    }

    public function test_assign_existing_user_to_activity(): void
    {
        $user = User::inRandomOrder()->first();
        $activity = new Activity([
            'name' => 'Test Activity',
            'description' => 'Test Activity Description',
            'success' => 0.5,
        ]);
        $step = Step::inRandomOrder()->first();
        $activity->step()->associate($step);
        $activity->save();

        $activity->users()->attach($user);
        $this->assertDatabaseHas('activity_user', [
            'user_id' => $user->id,
            'activity_id' => $activity->id
        ]);
    }

    public function test_assign_non_existing_user_to_activity(): void
    {
        $this->expectException(QueryException::class);

        $user = User::factory()->make();
        $activity = new Activity([
            'name' => 'Test Activity',
            'description' => 'Test Activity Description',
            'success' => 0.5,
        ]);
        $step = Step::inRandomOrder()->first();
        $activity->step()->associate($step);
        $activity->save();
        $activity->users()->attach($user);
    }
}
