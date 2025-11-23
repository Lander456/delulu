<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Activity;
use App\Models\Theme;
use App\Models\User;
use App\Models\Step;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( auth()->user()->hasRole(RolesEnum::SYSADMIN->value)){
            $activities = Activity::all();
            $ongoingActivities = $activities->where('completed', false)->values();
            $completedActivities = $activities->where('completed', true)->values();
            return view('activity.index', [
                'ongoingActivities' => $ongoingActivities,
                'completedActivities' => $completedActivities,
            ]);
        }

        $this->authorize('viewAny', Activity::class);

        $user = auth()->user();

        $activities = Activity::select('activities.*')
            ->join('steps', 'steps.id', '=', 'activities.step_id')
            ->join('campaigns', 'campaigns.id', '=', 'steps.campaign_id')
            ->join('campaign_user', 'campaign_user.campaign_id', '=', 'campaigns.id')
            ->where('campaign_user.user_id', $user->id)
            ->with(['step.campaign', 'step.user'])
            ->get();

        $ongoingActivities = $activities->where('completed', false)->values();
        $completedActivities = $activities->where('completed', true)->values();

        return view('activity.index', [
            'ongoingActivities' => $ongoingActivities,
            'completedActivities' => $completedActivities,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Activity::class);
        $steps = Step::all()
            ->filter(fn ($step) => Gate::allows('view', $step))
            ->values();

        return view('activity.create', compact('steps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Activity::class);

        $validated = $request->validate([
            'name' => ['required','string'],
            'description' => ['nullable','string','max:65535'],
            'step' => ['required','integer','exists:steps,id'],
        ]);

        $activity = new Activity([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);
        $step = $validated['step'];
        $activity->step()->associate($step);
        $activity->save();

        return redirect()
            ->route('steps.show', $step);
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        $this->authorize('view', $activity);

        $assignedUserIds = $activity->users->pluck('id');

        $campaignUserIds = $activity->step->campaign->users->pluck('id');
        $users = User::whereIn('id', $campaignUserIds)
            ->whereNotIn('id', $assignedUserIds)
            ->get();

        return view('activity.detail', compact('activity', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        $this->authorize('update', $activity);

        return view('activity.edit', ['activity' => $activity]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        $this->authorize('update', $activity);

        if ($request->has('users')){
            $validated = $request->validate([
                'users' => ['required','array'],
                'users.*' => ['required','integer','exists:users,id']
            ]);

            $activity->users()->sync($validated['users']);
        }

        if ($request->has('name')){
            $validated = $request->validate([
                'name' => ['required','string'],
            ]);

            $activity->update(['name' => $validated['name']]);
        }

        if ($request->has('description')){
            $validated = $request->validate([
                'description' => ['nullable','string'],
            ]);

            $activity->update(['description' => $validated['description']]);
        }

        if ($request->has('step_id')){
            $validated = $request->validate([
                'step_id' => ['required','integer','exists:steps,id'],
            ]);

            $activity->step()->associate($validated['step_id']);
        }

        $activity->save();

        $assignedUserIds = $activity->users->pluck('id');

        $campaignUserIds = $activity->step->campaign->users->pluck('id');
        $users = User::whereIn('id', $campaignUserIds)
            ->whereNotIn('id', $assignedUserIds)
            ->get();

        return view('activity.detail', compact('activity', 'users'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        $this->authorize('delete', $activity);

        $activity->delete();

        return redirect()->route('activities.index');
    }

    public function assignUsers(Request $request, Activity $activity)
    {
        $this->authorize('update', $activity);

        $validated = $request->validate([
            'users' => ['nullable','array'],
            'users.*' => ['exists:users,id'],
        ]);

        $existingUserIds = $activity->users()->pluck('users.id')->all();

        $activity->users()->sync(array_unique(array_merge($existingUserIds, $validated['users'])));


        $activity->save();

        return back();
    }

    public function unassignUser(Activity $activity, User $user)
    {
        $activity->users()->detach($user);

        return back();
    }

    public function mark(Request $request, Activity $activity)
    {
        $request->validate([
            'completed' => ['required','boolean']
        ]);

        $activity->users()->updateExistingPivot(auth()->id(), ['completed' => $request->completed]);

        $activity->recalculateSuccessRate();
        $activity->step->recalculateSuccessRate();
        $activity->step->campaign->recalculateSuccessRate();

        return back();
    }

    public function complete(Request $request, Activity $activity)
    {
        $this->authorize('update', $activity);

        $request->validate([
            'completed' => ['required','boolean']
        ]);

        $activity->update([
            'completed' => $request->boolean('completed')
        ]);

        return back();
    }
}
