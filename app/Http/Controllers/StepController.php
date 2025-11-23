<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Step;
use App\Models\User;
use App\Models\Campaign;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class StepController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Step::class);

        $steps = Step::with('activities', 'user')
            ->get()
            ->filter(fn ($step) => Gate::allows('view', $step))
            ->values();

        return view('step.index', compact('steps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Step::class);

        return view('step.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Step::class) ;

        $validated  = $request->validate([
            'name' => ['required','string'],
            'description' => ['nullable','string','max:65535'],
            'campaign_id' => ['required','exists:campaigns,id'],
            'user_id' => ['required','exists:users,id'],
        ]);

        $maxOrder = Step::where('campaign_id', $validated['campaign_id'])
            ->max('order');

        $validated['order'] = ($maxOrder != null) ? $maxOrder + 1 : 1;

        Step::create($validated);

        $campaign = Campaign::find($validated ['campaign_id']);
        return redirect()
            ->route('campaigns.show', $campaign);
    }

    /**
     * Display the specified resource.
     */
    public function show(Step $step)
    {
        $this->authorize('view', $step);

        return view('step.detail', compact('step'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Step $step)
    {
        $this->authorize('update', $step);
        $users = User::all();
        return view('step.edit', compact('step', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Step $step)
    {
        $this->authorize('update', $step);

        $validated = $request->validate([
            'name' => ['required','string'],
            'description' => ['string'],
            'campaign_id' => ['required','exists:campaigns,id'],
            'user_id' => ['required','exists:users,id'],
        ]);

        $step->update($validated);

        return redirect()
            ->route('steps.show', $step);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Step $step)
    {
        $this->authorize('delete', $step);

        $step->delete();

        return redirect('/steps');
    }

    public function assignActivity(Request $request, Step $step)
    {
        $this->authorize('update', $step);

        $validated = $request->validate([
            'activities' => ['nullable', 'array'],
            'activities.*' => ['exists:activities,id'],
        ]);

        if (!empty($validated['activities']))
        {
            Activity::whereIn('id', $validated['activities'])
                ->update(['step_id' => $step->id]);
        }

        return back();
    }

    public function unassignActivity(Step $step, Activity $activity)
    {
        $this->authorize('update', $step);

        if ($activity->step_id !== $step->id) {
            abort(403, 'This activity is not assigned to this step!');
        }

        $activity->update([
            'step_id' => null
        ]);

        return back();
    }
}
