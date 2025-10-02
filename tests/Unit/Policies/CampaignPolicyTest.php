<?php

namespace Tests\Unit\Policies;

use App\Enums\RolesEnum;
use App\Models\Campaign;
use App\Models\Theme;
use App\Models\User;
use App\Policies\CampaignPolicy;
use Tests\TestCase;

class CampaignPolicyTest extends TestCase
{

    private User $user;
    private CampaignPolicy $policy;

    private function setUpRegistered(string $role): void
    {
        $this->user = User::role($role)->inRandomOrder()->first();
        $this->policy = new CampaignPolicy();
    }

    private function setUpUnregistered(): void
    {
        $this->user = User::factory()->make();
        $this->policy = new CampaignPolicy();
    }

    /**
     * A basic unit test example.
     */
    public function test_block_unregistered_from_creating(): void
    {
        $this->setUpUnregistered();

        $this->assertFalse($this->policy->create($this->user));
    }

    public function test_block_unregistered_from_viewing_any(): void
    {
        $this->setUpUnregistered();

        $this->assertFalse($this->policy->viewAny($this->user));
    }

    public function test_block_unregistered_from_updating(): void
    {
        $this->setUpUnregistered();
        $campaign = Campaign::all()->first();

        $this->assertFalse($this->policy->update($this->user, $campaign));
    }

    public function test_block_unregistered_from_deleting(): void
    {
        $this->setUpUnregistered();
        $campaign = Campaign::all()->first();

        $this->assertFalse($this->policy->delete($this->user, $campaign));
    }

    public function test_block_worker_from_creating(): void
    {
        $this->setUpRegistered(RolesEnum::WORKER->value);

        $this->assertFalse($this->policy->create($this->user));
    }

    public function test_block_worker_from_viewing_any(): void
    {
        $this->setUpRegistered(RolesEnum::WORKER->value);

        $this->assertFalse($this->policy->viewAny($this->user));
    }

    public function test_block_worker_from_updating(): void
    {
        $this->setUpRegistered(RolesEnum::WORKER->value);
        $campaign = Campaign::all()->first();

        $this->assertFalse($this->policy->update($this->user, $campaign));
    }

    public function test_block_worker_from_deleting(): void
    {
        $this->setUpRegistered(RolesEnum::WORKER->value);
        $campaign = Campaign::all()->first();

        $this->assertFalse($this->policy->delete($this->user, $campaign));
    }

    public function test_block_coordinator_from_creating(): void
    {
        $this->setUpRegistered(RolesEnum::COORDINATOR->value);

        $this->assertFalse($this->policy->create($this->user));
    }

    public function test_block_coordinator_from_viewing_any(): void
    {
        $this->setUpRegistered(RolesEnum::COORDINATOR->value);

        $this->assertFalse($this->policy->viewAny($this->user));
    }

    public function test_block_coordinator_from_updating(): void
    {
        $this->setUpRegistered(RolesEnum::COORDINATOR->value);
        $campaign = Campaign::all()->first();

        $this->assertFalse($this->policy->update($this->user, $campaign));
    }

    public function test_block_coordinator_from_deleting(): void
    {
        $this->setUpRegistered(RolesEnum::COORDINATOR->value);
        $campaign = Campaign::all()->first();

        $this->assertFalse($this->policy->delete($this->user, $campaign));
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

    public function test_allow_campaign_leader_to_update_owned(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);
        $campaign = Campaign::where('user_id', $this->user->id)->first();

        $this->assertTrue($this->policy->update($this->user, $campaign));
    }

    public function test_block_campaign_leader_from_updating_unowned(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);
        $campaign = Campaign::where('user_id', '!=', $this->user->id)->first();

        $this->assertFalse($this->policy->update($this->user, $campaign));
    }

    public function test_allow_campaign_leader_to_delete_owned(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);
        $campaign = Campaign::where('user_id', $this->user->id)->first();

        $this->assertTrue($this->policy->delete($this->user, $campaign));
    }

    public function test_block_campaign_leader_from_deleting_unowned(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);
        $campaign = Campaign::where('user_id', '!=', $this->user->id)->first();

        $this->assertFalse($this->policy->delete($this->user, $campaign));
    }

    public function test_allow_admin_to_create(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);

        $this->assertTrue($this->policy->create($this->user));
    }

    public function test_allow_admin_to_view_any(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);

        $this->assertTrue($this->policy->viewAny($this->user));
    }

    public function test_allow_admin_to_update_owned(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $theme = Theme::where('user_id', $this->user->id)->first();
        $campaign = Campaign::where('theme_id', $theme->id)->first();

        $this->assertTrue($this->policy->update($this->user, $campaign));
    }

    public function test_block_admin_from_updating_unowned(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $theme = Theme::where('user_id', $this->user->id)->first();
        $campaign = Campaign::where('theme_id', $theme->id)->first();

        $this->assertTrue($this->policy->update($this->user, $campaign));
    }

    public function test_allow_admin_to_delete_owned(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $theme = Theme::where('user_id', $this->user->id)->first();
        $campaign = Campaign::where('theme_id', $theme->id)->first();

        $this->assertTrue($this->policy->delete($this->user, $campaign));
    }

    public function test_block_admin_from_deleting_unowned(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $theme = Theme::where('user_id', '!=', $this->user->id)->first();
        $campaign = Campaign::where('theme_id', $theme->id)->first();

        $this->assertFalse($this->policy->delete($this->user, $campaign));
    }
}
