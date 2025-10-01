<?php

namespace Tests\Unit\Policies;

use App\Enums\RolesEnum;
use App\Models\User;
use App\Policies\AreaOfInterestPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AreaOfInterestPolicyTests extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private AreaOfInterestPolicy $policy;

    private function setUpRegistered(string $role): void
    {
        $this->user = User::role($role)->inRandomOrder()->first();
        $this->policy = new AreaOfInterestPolicy();
    }

    private function setUpUnregistered(): void
    {
        $this->user = User::factory()->make();
        $this->policy = new AreaOfInterestPolicy();
    }

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

        $this->assertFalse($this->policy->update($this->user));
    }

    public function test_block_unregistered_from_deleting(): void
    {
        $this->setUpUnregistered();

        $this->assertFalse($this->policy->delete($this->user));
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

        $this->assertFalse($this->policy->update($this->user));
    }

    public function test_block_worker_from_deleting(): void
    {
        $this->setUpRegistered(RolesEnum::WORKER->value);

        $this->assertFalse($this->policy->delete($this->user));
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

        $this->assertFalse($this->policy->update($this->user));
    }

    public function test_block_coordinator_from_deleting(): void
    {
        $this->setUpRegistered(RolesEnum::COORDINATOR->value);

        $this->assertFalse($this->policy->delete($this->user));
    }

    public function test_block_campaign_leader_from_creating(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);

        $this->assertFalse($this->policy->create($this->user));
    }

    public function test_block_campaign_leader_from_viewing_any(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);

        $this->assertFalse($this->policy->viewAny($this->user));
    }

    public function test_block_campaign_leader_from_updating(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);

        $this->assertFalse($this->policy->update($this->user));
    }

    public function test_block_campaign_leader_from_deleting(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);

        $this->assertFalse($this->policy->delete($this->user));
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

    public function test_allow_admin_to_update(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);

        $this->assertTrue($this->policy->update($this->user));
    }

    public function test_allow_admin_to_delete(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);

        $this->assertTrue($this->policy->delete($this->user));
    }
}
