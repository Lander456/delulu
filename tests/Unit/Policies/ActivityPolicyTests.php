<?php

namespace Tests\Unit\Policies;

use App\Enums\RolesEnum;
use App\Models\Activity;
use App\Models\Campaign;
use App\Models\Step;
use App\Models\Theme;
use App\Models\User;
use App\Policies\ActivityPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityPolicyTests extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private ActivityPolicy $policy;

    private function setUpRegistered(string $role): void
    {
        $this->user = User::role($role)->inRandomOrder()->first();
        $this->policy = new ActivityPolicy();
    }

    private function setUpUnregistered(): void
    {
        $this->user = User::factory()->make();
        $this->policy = new ActivityPolicy();
    }

    /**
     * testing whether an unregistered user is blocked from creating any activities
     */
    public function test_block_unregistered_from_creating(): void
    {
        $this->setUpUnregistered();

        $this->assertFalse($this->policy->create($this->user));
    }

    /**
     * testing whether an unregistered user is blocked from viewing any activities
     */
    public function test_block_unregistered_from_viewing_any(): void
    {
        $this->setUpUnregistered();

        $this->assertFalse($this->policy->viewAny($this->user));
    }

    /**
     * testing whether an unregistered user is blocked from editing any activities
     */
    public function test_block_unregistered_from_updating(): void
    {
        $this->setUpUnregistered();
        $activity = Activity::inRandomOrder()->first();

        $this->assertFalse($this->policy->update($this->user, $activity));
    }

    /**
     * testing whether an unregistered user is blocked from deleting any activities
     */
    public function test_block_unregistered_from_deleting(): void
    {
        $this->setUpUnregistered();
        $activity = Activity::inRandomOrder()->first();

        $this->assertFalse($this->policy->delete($this->user, $activity));
    }

    /**
     * testing whether a worker is blocked from creating activities
     */
    public function test_block_worker_from_creating(): void
    {
        $this->setUpRegistered(RolesEnum::WORKER->value);

        $this->assertFalse($this->policy->create($this->user));
    }

    /**
     * testing whether a worker can view any of the activities
     */
    public function test_allow_worker_to_view_any(): void
    {
        $this->setUpRegistered(RolesEnum::WORKER->value);

        $this->assertTrue($this->policy->viewAny($this->user));
    }

    /**
     * testing whether a worker is blocked from editing any activity
     */
    public function test_block_worker_from_updating(): void
    {
        $this->setUpRegistered(RolesEnum::WORKER->value);
        $activity = Activity::inRandomOrder()->first();

        $this->assertFalse($this->policy->update($this->user, $activity));
    }

    /**
     * testing whether a worker is blocked from deleting any activity
     */
    public function test_block_worker_from_deleting(): void
    {
        $this->setUpRegistered(RolesEnum::WORKER->value);
        $activity = Activity::inRandomOrder()->first();

        $this->assertFalse($this->policy->delete($this->user, $activity));
    }

    public function test_allow_coordinator_to_create(): void
    {
        $this->setUpRegistered(RolesEnum::COORDINATOR->value);

        $this->assertTrue($this->policy->create($this->user));
    }

    public function test_allow_coordinator_to_view_any(): void
    {
        $this->setUpRegistered(RolesEnum::COORDINATOR->value);

        $this->assertTrue($this->policy->viewAny($this->user));
    }

    public function test_allow_coordinator_to_update_owned_activity(): void
    {
        $this->setUpRegistered(RolesEnum::COORDINATOR->value);
        $stepId = Step::where('user_id', $this->user->id)->first()->id;
        $activity = Activity::where('step_id', $stepId)->first();

        $this->assertTrue($this->policy->update($this->user, $activity));
    }

    public function test_block_coordinator_from_updating_unowned_activity(): void
    {
        $this->setUpRegistered(RolesEnum::COORDINATOR->value);
        $step = Step::where('user_id', '!=', $this->user->id)->first();
        $activity = Activity::where('step_id', $step->id)->first();

        $this->assertFalse($this->policy->update($this->user, $activity));
    }

    public function test_allow_coordinator_to_delete_owned_activity(): void
    {
        $this->setUpRegistered(RolesEnum::COORDINATOR->value);
        $stepId = Step::where('user_id', $this->user->id)->first()->id;
        $activity = Activity::where('step_id', $stepId)->first();

        $this->assertTrue($this->policy->delete($this->user, $activity));
    }

    public function test_block_coordinator_from_deleting_unowned_activity(): void
    {
        $this->setUpRegistered(RolesEnum::COORDINATOR->value);
        $step = Step::where('user_id', '!=', $this->user->id)->first();
        $activity = Activity::where('step_id', $step->id)->first();

        $this->assertFalse($this->policy->delete($this->user, $activity));
    }

    public function test_allow_campaign_leader_to_create(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);

        $this->assertTrue($this->policy->create($this->user));
    }

    public function test_allow_campaign_leader_to_view_any(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);

        $this->assertTrue($this->policy->viewAny($this->user));
    }

    public function test_allow_campaign_leader_to_update_owned_activity(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);
        $campaign = Campaign::where('user_id', $this->user->id)->first();
        $step = Step::where('campaign_id', $campaign->id)->first();
        $activity = Activity::where('step_id', $step->id)->first();

        $this->assertTrue($this->policy->update($this->user, $activity));
    }

    public function test_block_campaign_leader_from_updating_unowned_activity(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);
        $campaign = Campaign::where('user_id', '!=' ,$this->user->id)->first();
        $step = Step::where('campaign_id', $campaign->id)->first();
        $activity = Activity::where('step_id', $step->id)->first();

        $this->assertFalse($this->policy->update($this->user, $activity));
    }

    public function test_allow_campaign_leader_to_delete_owned_activity(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);
        $campaign = Campaign::where('user_id', $this->user->id)->first();
        $step = Step::where('campaign_id', $campaign->id)->first();
        $activity = Activity::where('step_id', $step->id)->first();

        $this->assertTrue($this->policy->delete($this->user, $activity));
    }

    public function test_block_campaign_leader_from_deleting_unowned_activity(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);
        $campaign = Campaign::where('user_id', '!=', $this->user->id)->first();
        $step = Step::where('campaign_id', $campaign->id)->first();
        $activity = Activity::where('step_id', $step->id)->first();

        $this->assertFalse($this->policy->delete($this->user, $activity));
    }

    public function test_allow_admin_to_view_any_activity(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);

        $this->assertTrue($this->policy->viewAny($this->user));
    }

    public function test_allow_admin_to_create_activity(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);

        $this->assertTrue($this->policy->create($this->user));
    }

    public function test_allow_admin_to_update_owned_activity(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $theme = Theme::where('user_id', $this->user->id)->first();
        $campaign = Campaign::where('theme_id', $theme->id)->first();
        $step = Step::where('campaign_id', $campaign->id)->first();
        $activity = Activity::where('step_id', $step->id)->first();

        $this->assertTrue($this->policy->update($this->user, $activity));
    }

    public function test_block_admin_from_updating_unowned_activity(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $theme = Theme::where('user_id','!=' , $this->user->id)->first();
        $campaign = Campaign::where('theme_id', $theme->id)->first();
        $step = Step::where('campaign_id', $campaign->id)->first();
        $activity = Activity::where('step_id', $step->id)->first();

        $this->assertFalse($this->policy->update($this->user, $activity));
    }

    public function test_allow_admin_to_delete_owned_activity(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $theme = Theme::where('user_id', $this->user->id)->first();
        $campaign = Campaign::where('theme_id', $theme->id)->first();
        $step = Step::where('campaign_id', $campaign->id)->first();
        $activity = Activity::where('step_id', $step->id)->first();

        $this->assertTrue($this->policy->delete($this->user, $activity));
    }

    public function test_block_admin_from_deleting_unowned_activity(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $theme = Theme::where('user_id','!=' , $this->user->id)->first();
        $campaign = Campaign::where('theme_id', $theme->id)->first();
        $step = Step::where('campaign_id', $campaign->id)->first();
        $activity = Activity::where('step_id', $step->id)->first();

        $this->assertFalse($this->policy->update($this->user, $activity));
    }
}
