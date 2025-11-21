<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Theme;
use App\Models\User;
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
        $this->authorize('viewAny', Activity::class);

        $activities = Activity::with(['step.user'])->get()
            ->filter(fn ($activity) => Gate::allows('view', $activity))
            ->values();

        return view('activity.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Activity::class);

        return view('activity.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Activity::class);

        $validated = $request->validate([
            'name' => ['required','string','unique:activities,name'],
            'description' => ['nullable','string'],
            'step' => ['required','integer','exists:steps,id'],
        ]);

        $activity = new Activity([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        $activity->step()->associate($validated['step']);
        $activity->save();

        $users = User::all();

        return view('activity.detail', compact('activity', 'users'))->with('success', 'Activity created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        $this->authorize('view', $activity);

        $assignedUserIds = $activity->users->pluck('id');

        $users = User::whereNotIn('id', $assignedUserIds)->get();

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
                'name' => ['required','string','unique:activities,name'],
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
        $users = User::all();
        return view('activity.detail', compact('activity', 'users'))->with('success', 'Activity updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        $this->authorize('delete', $activity);

        $activity->delete();

        return redirect()->back()->with('success', 'Activity deleted!');
    }

    public function assignUsers(Request $request, Activity $activity)
    {
        $this->authorize('update', $activity);

        $validated = $request->validate([
            'users' => ['nullable','array'],
            'users.*' => ['exists:users,id'],
        ]);

        $activity->users()->sync(array_merge($validated['users'], $activity->users()->pluck('id')->toArray()));
        $activity->save();

        return back()->with('success', 'Users assigned to activity!');
    }

    public function unassignUser(Activity $activity, User $user)
    {
        $activity->users()->detach($user);

        return back()->with('success', 'User unassigned from activity!');
    }

    public function mark(Request $request, Activity $activity)
    {
        $request->validate([
            'completed' => ['required','boolean']
        ]);

        $activity->users()->updateExistingPivot(auth()->id(), ['completed' => $request->completed]);

        return back()->with('success', 'Activity completed!');
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
