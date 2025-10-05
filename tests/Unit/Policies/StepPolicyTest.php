<?php

namespace Tests\Unit\Policies;

use App\Enums\RolesEnum;
use App\Models\Campaign;
use App\Models\Step;
use App\Models\User;
use App\Policies\StepPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StepPolicyTest extends TestCase
{

    use RefreshDatabase;

    private User $user;
    private StepPolicy $policy;

    private function setUpRegistered(string $role): void
    {
        $this->user = User::role($role)->inRandomOrder()->first();
        $this->policy = new StepPolicy();
    }

    private function setUpUnregistered(): void
    {
        $this->user = User::factory()->make();
        $this->policy = new StepPolicy();
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

    public function test_block_unregistered_from_updating_any(): void
    {
        $this->setUpUnregistered();
        $steps = Step::all();

        foreach ($steps as $step) {
            $this->assertFalse($this->policy->update($this->user, $step));
        }
    }

    public function test_block_unregistered_from_deleting_any(): void
    {
        $this->setUpUnregistered();
        $steps = Step::all();

        foreach ($steps as $step) {
            $this->assertFalse($this->policy->delete($this->user, $step));
        }
    }

    public function test_block_worker_from_viewing_any(): void
    {
        $this->setUpRegistered(RolesEnum::WORKER->value);

        $this->assertFalse($this->policy->viewAny($this->user));
    }

    public function test_block_worker_from_creating(): void
    {
        $this->setUpRegistered(RolesEnum::WORKER->value);

        $this->assertFalse($this->policy->create($this->user));
    }

    public function test_block_worker_from_updating_any(): void
    {
        $this->setUpRegistered(RolesEnum::WORKER->value);
        $steps = Step::all();

        foreach ($steps as $step) {
            $this->assertFalse($this->policy->update($this->user, $step));
        }
    }

    public function test_block_worker_from_deleting_any(): void
    {
        $this->setUpRegistered(RolesEnum::WORKER->value);
        $steps = Step::all();

        foreach ($steps as $step) {
            $this->assertFalse($this->policy->delete($this->user, $step));
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

    public function test_block_coordinator_from_viewing_unassigned(): void
    {
        $this->setUpRegistered(RolesEnum::COORDINATOR->value);
        $steps = Step::where('user_id', '!=', $this->user->id)->get();

        foreach ($steps as $step) {
            $this->assertFalse($this->policy->view($this->user, $step));
        }
    }

    public function test_allow_coordinator_to_view_assigned(): void
    {
        $this->setUpRegistered(RolesEnum::COORDINATOR->value);
        $steps = Step::where('user_id', $this->user->id)->get();

        foreach ($steps as $step) {
            $this->assertTrue($this->policy->view($this->user, $step));
        }
    }

    public function test_block_coordinator_from_updating_unassigned(): void
    {
        $this->setUpRegistered(RolesEnum::COORDINATOR->value);
        $steps = Step::where('user_id', '!=', $this->user->id)->get();

        foreach ($steps as $step) {
            $this->assertFalse($this->policy->update($this->user, $step));
        }
    }

    public function test_allow_coordinator_to_update_assigned(): void
    {
        $this->setupRegistered(RolesEnum::COORDINATOR->value);
        $steps = Step::where('user_id', $this->user->id)->get();

        foreach ($steps as $step) {
            $this->assertTrue($this->policy->update($this->user, $step));
        }
    }

    public function test_block_coordinator_from_deleting_any(): void
    {
        $this->setUpRegistered(RolesEnum::COORDINATOR->value);
        $steps = Step::all();

        foreach ($steps as $step) {
            $this->assertFalse($this->policy->delete($this->user, $step));
        }
    }

    public function test_allow_campaign_leader_to_create(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);

        $this->assertTrue($this->policy->create($this->user));
    }

    public function test_block_campaign_leader_from_viewing_any(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);

        $this->assertFalse($this->policy->viewAny($this->user));
    }

    public function test_allow_campaign_leader_to_view_directly_owned(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);
        $steps = Step::where('user_id', $this->user->id)->get();

        foreach ($steps as $step) {
            $this->assertTrue($this->policy->view($this->user, $step));
        }
    }

    public function test_allow_campaign_leader_to_view_indirectly_owned(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);
        $campaigns = Campaign::where('user_id', $this->user->id)->get();
        foreach ($campaigns as $campaign) {

            $steps = Step::where([
                ['campaign_id', '=', $campaign->id],
                ['user_id', '!=', $this->user->id]
            ])->get();

            foreach ($steps as $step) {
                $this->assertTrue($this->policy->view($this->user, $step));
            }
        }
    }

    public function test_block_campaign_leader_from_viewing_unowned(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);
        $campaigns = Campaign::where('user_id', '!=', $this->user->id)->get();
        foreach ($campaigns as $campaign) {

            $steps = Step::where([
                ['campaign_id', '=', $campaign->id],
                ['user_id', '!=', $this->user->id]
            ])->get();

            foreach ($steps as $step) {
                $this->assertFalse($this->policy->view($this->user, $step));
            }
        }
    }

    public function test_allow_campaign_leader_to_update_directly_owned(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);
        $steps = Step::where('user_id', $this->user)->get();

        foreach ($steps as $step) {
            $this->assertTrue($this->policy->update($this->user, $step));
        }
    }

    public function test_allow_campaign_leader_to_update_indirectly_owned(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);
        $campaigns = Campaign::where('user_id', '=', $this->user->id)->get();

        foreach ($campaigns as $campaign) {
            $steps = Step::where([
                ['campaign_id', '=', $campaign->id],
                ['user_id', '!=', $this->user->id]
            ])->get();
            foreach ($steps as $step) {
                $this->assertTrue($this->policy->update($this->user, $step));
            }
        }
    }

    public function test_block_campaign_leader_from_updating_unowned(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);
        $campaigns = Campaign::where('user_id', '!=', $this->user->id)->get();
        foreach ($campaigns as $campaign) {
            $steps = Step::where([
                ['campaign_id', '=', $campaign->id],
                ['user_id', '!=', $this->user->id]
            ])->get();
            foreach ($steps as $step) {
                $this->assertFalse($this->policy->update($this->user, $step));
            }
        }
    }

    public function test_allow_campaign_leader_to_delete_directly_owned(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);
        $steps = Step::where('user_id', '=', $this->user->id)->get();

        foreach ($steps as $step) {
            $this->assertTrue($this->policy->delete($this->user, $step));
        }
    }

    public function test_allow_campaign_leader_to_delete_indirectly_owned(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);
        $campaigns = Campaign::where('user_id', '=', $this->user->id)->get();

        foreach ($campaigns as $campaign) {

            $steps = Step::where([
                ['campaign_id', '=', $campaign->id],
                ['user_id', '!=', $this->user->id]
            ])->get();

            foreach ($steps as $step) {
                $this->assertTrue($this->policy->delete($this->user, $step));
            }
        }
    }

    public function test_block_campaign_leader_from_deleting_unowned(): void
    {
        $this->setUpRegistered(RolesEnum::CAMPAIGN_LEADER->value);
        $campaignIds = Campaign::where('user_id', '!=', $this->user->id)->pluck('id');

        foreach ($campaignIds as $campaignId) {

            $steps = Step::where([
                ['campaign_id', '=', $campaignId],
                ['user_id', '!=', $this->user->id]
            ])->get();

            foreach ($steps as $step) {
                $this->assertFalse($this->policy->delete($this->user, $step));
            }
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

    public function test_allow_admin_to_view_directly_owned(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $steps = Step::where('user_id', '=', $this->user->id)->get();

        foreach ($steps as $step) {
            $this->assertTrue($this->policy->view($this->user, $step));
        }
    }

    public function test_allow_admin_to_view_indirectly_owned(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $campaignIds = Campaign::where(function ($query) {
            $query->where('user_id', $this->user->id)
                ->orWhereIn('theme_id', function ($subquery) {
                    $subquery->select('id')
                        ->from('themes')
                        ->where('user_id', $this->user->id);
                });
        })->pluck('id');

        foreach ($campaignIds as $campaignId) {

            $steps = Step::where([
                ['campaign_id', '=', $campaignId],
                ['user_id', '!=', $this->user->id]
            ])->get();

            foreach ($steps as $step) {
                $this->assertTrue($this->policy->view($this->user, $step));
            }
        }
    }

    public function test_block_admin_from_viewing_unowned(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $campaignIds = Campaign::where('user_id', '!=', $this->user->id)
            ->whereIn('theme_id', function ($subquery) {
                $subquery->select('id')
                    ->from('themes')
                    ->where('user_id', '!=', $this->user->id);
            })->pluck('id');

        foreach ($campaignIds as $campaignId) {

            $steps = Step::where([
                ['user_id', '!=', $this->user->id],
                ['campaign_id','=' ,$campaignId]
            ])->get();

            foreach ($steps as $step) {
                $this->assertFalse($this->policy->view($this->user, $step));
            }
        }
    }

    public function test_allow_admin_to_update_directly_owned(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $steps = Step::where('user_id', '=', $this->user->id)->get();

        foreach ($steps as $step) {
            $this->assertTrue($this->policy->update($this->user, $step));
        }
    }

    public function test_allow_admin_to_update_indirectly_owned(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $campaignIds = Campaign::where(function ($query) {
            $query->where('user_id', '=', $this->user->id)
                ->orWhereIn('theme_id', function ($subquery) {
                    $subquery->select('id')
                        ->from('themes')
                        ->where('user_id','=' , $this->user->id);
                });
        })->pluck('id');

        foreach($campaignIds as $campaignId) {
            $steps = Step::where('campaign_id', '=', $campaignId)->get();

            foreach ($steps as $step) {
                $this->assertTrue($this->policy->update($this->user, $step));
            }
        }
    }

    public function test_block_admin_from_updating_unowned(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $campaignIds = Campaign::where(function ($query) {
            $query->where('user_id','!=' , $this->user->id)
                ->whereIn('theme_id', function ($subquery) {
                    $subquery->select('id')
                        ->from('themes')
                        ->where('user_id','!=' , $this->user->id);
                });
        })->pluck('id');

        foreach ($campaignIds as $campaignId) {
            $steps = Step::where('campaign_id', '=', $campaignId)->get();
            foreach ($steps as $step) {
                $this->assertFalse($this->policy->update($this->user, $step));
            }
        }
    }

    public function test_allow_admin_to_delete_directly_owned(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $steps = Step::where('user_id', '=', $this->user->id)->get();

        foreach ($steps as $step) {
            $this->assertTrue($this->policy->delete($this->user, $step));
        }
    }

    public function test_allow_admin_to_delete_indirectly_owned(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $campaignIds = Campaign::where(function ($query) {
            $query->where('user_id','=' , $this->user->id)
                ->orWhereIn('theme_id', function ($subquery) {
                    $subquery->select('id')
                        ->from('themes')
                        ->where('user_id','=' , $this->user->id);
                });
        })->pluck('id');

        foreach ($campaignIds as $campaignId) {
            $steps = Step::where('campaign_id', '=', $campaignId)->get();
            foreach ($steps as $step) {
                $this->assertTrue($this->policy->delete($this->user, $step));
            }
        }
    }

    public function test_block_admin_from_deleting_unowned(): void
    {
        $this->setUpRegistered(RolesEnum::ADMIN->value);
        $campaignIds = Campaign::where(function ($query) {
            $query->where('user_id','!=' , $this->user->id)
                ->whereIn('theme_id', function ($subquery) {
                    $subquery->select('id')
                        ->from('themes')
                        ->where('user_id','!=' , $this->user->id);
                });
        })->pluck('id');

        foreach ($campaignIds as $campaignId) {
            $steps = Step::where('campaign_id', '=', $campaignId)->get();
            foreach ($steps as $step) {
                $this->assertFalse($this->policy->delete($this->user, $step));
            }
        }
    }
}
