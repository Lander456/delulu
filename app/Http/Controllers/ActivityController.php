<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Theme;
use App\Models\User;
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
        $this->authorize('view', Activity::class);

        return Activity::all();
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

        $activity = $request->validate([
            'name' => ['required','string','unique:activities,name'],
            'description' => ['string'],
            'step_id' => ['required','exists:steps,id'],
        ]);

        Activity::create($activity);

        return redirect('/activities')->with('success', 'Activity created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        $this->authorize('view', $activity);

        return view('activity.detail', ['activity' => $activity]);
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

        $validated = $request->validate([
            'name' => ['required','string','unique:activities,name'],
            'description' => ['string'],
            'step_id' => ['required','exists:steps,id']
        ]);

        $activity->update($validated);

        return redirect('/activities')->with('success', 'Activity updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        $this->authorize('delete', $activity);

        $activity->delete();

        return redirect('/activities')->with('success', 'Activity deleted!');
    }
}
