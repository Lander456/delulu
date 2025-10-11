<?php

namespace Tests\Unit\Models;

use App\Models\Activity;
use App\Models\AreaOfInterest;
use App\Models\TargetDemographic;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    public function test_create_valid(): void
    {
        $user = new User([
            'username' => 'testUser',
            'email' => 'example@example.com',
            'password' => 'testPassword'
        ]);

        $user->save();

        $this->assertDatabaseHas('users', [
            'username' => 'testUser',
            'email' => 'example@example.com'
        ]);
    }

    public function test_create_without_username(): void
    {
        $this->expectException(QueryException::class);
        $user = new User([
            'email' => 'example@example.com',
            'password' => 'testPassword'
        ]);

        $user->save();
    }

    public function test_create_without_email(): void
    {
        $this->expectException(QueryException::class);
        $user = new User([
            'username' => 'testUser',
            'password' => 'testPassword'
        ]);

        $user->save();
    }

    public function test_create_without_password(): void
    {
        $this->expectException(QueryException::class);
        $user = new User([
            'username' => 'testUser',
            'email' => 'example@example.com'
        ]);

        $user->save();
    }

    public function test_attach_existing_area_of_interest(): void
    {
        $areaOfInterest = AreaOfInterest::inRandomOrder()->first();
        $user = User::factory()->create();

        $user->areasOfInterest()->attach($areaOfInterest);

        $this->assertDatabaseHas('area_of_interest_user', [
            'user_id' => $user->id,
            'area_of_interest_id' => $areaOfInterest->id
        ]);
    }

    public function test_attach_non_existing_area_of_interest(): void
    {
        $this->expectException(QueryException::class);
        $areaOfInterest = AreaOfInterest::factory()->make();
        $user = User::factory()->create();

        $user->areasOfInterest()->attach($areaOfInterest);
    }

    public function test_attach_existing_target_demographic(): void
    {
        $targetDemographic = TargetDemographic::inRandomOrder()->first();
        $user = User::factory()->create();

        $user->targetDemographics()->attach($targetDemographic);

        $this->assertDatabaseHas('target_demographic_user', [
            'user_id' => $user->id,
            'target_demographic_id' => $targetDemographic->id
        ]);
    }

    public function test_attach_non_existing_target_demographic(): void
    {
        $this->expectException(QueryException::class);
        $targetDemographic = TargetDemographic::factory()->make();
        $user = User::factory()->create();

        $user->targetDemographics()->attach($targetDemographic);
    }

    public function test_attach_existing_activity(): void
    {
        $activity = Activity::inRandomOrder()->first();
        $user = User::factory()->create();

        $user->activities()->attach($activity);

        $this->assertDatabaseHas('activity_user', [
            'user_id' => $user->id,
            'activity_id' => $activity->id
        ]);
    }

    public function test_attach_non_existing_activity(): void
    {
        $this->expectException(QueryException::class);
        $activity = Activity::factory()->make();
        $user = User::factory()->create();

        $user->activities()->attach($activity);
    }
}
