<?php

namespace Tests\Unit\Policies;

use App\Enums\RolesEnum;
use App\Models\Theme;
use App\Models\User;
use App\Policies\ThemePolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThemePolicyTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private ThemePolicy $policy;

    private function setUpRegistered(string $role): void
    {
        $this->user = User::role($role)->inRandomOrder()->first();
        $this->policy = new ThemePolicy();
    }

    private function setUpUnregistered(): void
    {
        $this->user = User::factory()->make();
        $this->policy = new ThemePolicy();
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

    public function test_block_unregistered_from_viewing(): void
    {
        $this->setUpUnregistered();
        $themes = Theme::all();

        foreach ($themes as $theme) {
            $this->assertFalse($this->policy->view($this->user, $theme));
        }
    }

    public function test_block_unregistered_from_updating(): void
    {
        $this->setUpUnregistered();
        $themes = Theme::all();

        foreach ($themes as $theme) {
            $this->assertFalse($this->policy->update($this->user, $theme));
        }
    }

    public function test_block_unregistered_from_deleting(): void
    {
        $this->setUpUnregistered();
        $themes = Theme::all();

        foreach ($themes as $theme) {
            $this->assertFalse($this->policy->delete($this->user, $theme));
        }
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

    public function test_block_worker_from_viewing(): void
    {
        $this->setUpRegistered(RolesEnum::WORKER->value);
        $themes = Theme::all();

        foreach ($themes as $theme) {
            $this->assertFalse($this->policy->view($this->user, $theme));
        }
    }

    public function test_block_worker_from_updating(): void
    {
        $this->setUpRegistered(RolesEnum::WORKER->value);
        $themes = Theme::all();

        foreach ($themes as $theme) {
            $this->assertFalse($this->policy->update($this->user, $theme));
        }
    }

    public function test_block_worker_from_deleting(): void
    {
        $this->setUpRegistered(RolesEnum::WORKER->value);
        $themes = Theme::all();

        foreach ($themes as $theme) {
            $this->assertFalse($this->policy->delete($this->user, $theme));
        }
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

    public function test_block_coordinator_from_viewing(): void
    {
        $this->setUpRegistered(RolesEnum::COORDINATOR->value);
        $themes = Theme::all();

        foreach ($themes as $theme) {
            $this->assertFalse($this->policy->view($this->user, $theme));
        }
    }

    public function test_block_coordinator_from_updating(): void
    {
        $this->setUpRegistered(RolesEnum::COORDINATOR->value);
        $themes = Theme::all();

        foreach ($themes as $theme) {
            $this->assertFalse($this->policy->update($this->user, $theme));
        }
    }

    public function test_block_coordinator_from_deleting(): void
    {
        $this->setUpRegistered(RolesEnum::COORDINATOR->value);
        $themes = Theme::all();

        foreach ($themes as $theme){
            $this->assertFalse($this->policy->delete($this->user, $theme));
        }
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

    public function test_block_campaign_leader_from_viewing(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);
        $themes = Theme::all();

        foreach ($themes as $theme){
            $this->assertFalse($this->policy->view($this->user, $theme));
        }
    }

    public function test_block_campaign_leader_from_updating(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);
        $themes = Theme::all();

        foreach ($themes as $theme){
            $this->assertFalse($this->policy->update($this->user, $theme));
        }
    }

    public function test_block_campaign_leader_from_deleting(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);
        $themes = Theme::all();

        foreach ($themes as $theme){
            $this->assertFalse($this->policy->delete($this->user, $theme));
        }
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

    public function test_allow_admin_to_view_owned(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $themes = Theme::where('user_id', '=', $this->user->id)->get();

        foreach ($themes as $theme){
            $this->assertTrue($this->policy->view($this->user, $theme));
        }
    }

    public function test_block_admin_from_viewing_unowned(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $themes = Theme::where('user_id', '!=', $this->user->id)->get();

        foreach ($themes as $theme){
            $this->assertFalse($this->policy->view($this->user, $theme));
        }
    }

    public function test_allow_admin_to_update_owned(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $themes = Theme::where('user_id', '=', $this->user->id)->get();

        foreach ($themes as $theme){
            $this->assertTrue($this->policy->update($this->user, $theme));
        }
    }

    public function test_block_admin_from_updating_unowned(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $themes = Theme::where('user_id', '!=', $this->user->id)->get();

        foreach ($themes as $theme){
            $this->assertFalse($this->policy->update($this->user, $theme));
        }
    }

    public function test_allow_admin_to_delete_owned(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $themes = Theme::where('user_id', '=', $this->user->id)->get();

        foreach ($themes as $theme){
            $this->assertTrue($this->policy->delete($this->user, $theme));
        }
    }

    public function test_block_admin_from_deleting_unowned(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $themes = Theme::where('user_id', '!=', $this->user->id)->get();

        foreach ($themes as $theme){
            $this->assertFalse($this->policy->delete($this->user, $theme));
        }
    }
}
