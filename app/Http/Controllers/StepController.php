<?php

namespace App\Http\Controllers;

use App\Models\Step;
use App\Models\User;
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
        $this->authorize('create', Step::class);

        $step = $request->validate([
            'name' => ['required','string'],
            'description' => ['string'],
            'campaign_id' => ['required','exists:campaigns,id'],
            'user_id' => ['required','exists:users,id'],
        ]);

        Step::create($step);

        return redirect('/steps')->with('success', 'Step created!');
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

        return view('step.edit', compact('step'));
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

        return redirect('/steps')->with('success', 'Step updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Step $step)
    {
        $this->authorize('delete', $step);

        $step->delete();

        return redirect('/steps')->with('success', 'Step deleted!');
    }
}
