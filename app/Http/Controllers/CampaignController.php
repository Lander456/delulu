<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Campaign;
use App\Models\Step;
use App\Models\Theme;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User;


class CampaignController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Campaign::class);

        $campaigns = Campaign::all()
            ->filter( fn ($campaign) => Gate::allows('view', $campaign))
            ->values();

        return view('campaign.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Campaign::class);

        return view('campaign.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Campaign::class);

        $campaign = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['string'],
            'theme_id' => ['required', 'exists:themes,id'],
            'user_id' => ['required', 'exists:users,id'],
            'current_step_id' => ['exists:steps,id'],
        ]);

        Campaign::create($campaign);

        return redirect()->route('/campaigns')->with('success', 'Campaign created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        $this->authorize('view', $campaign);

        return view('campaign.detail', compact('campaign'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $users = User::all();
        $themes = Theme::all();
        $steps = $campaign->steps;
        return view('campaign.edit', compact('campaign', 'users', 'themes', 'steps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $validated = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable','string','max:65535'],
            'theme_id' => ['required', 'exists:themes,id'],
            'user_id' => ['required', 'exists:users,id'],
            'current_step_id' => ['exists:steps,id']
        ]);

        $campaign->update($validated);

        return view('campaign.detail', compact('campaign'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        $this->authorize('delete', $campaign);

        $campaign->delete();

        return redirect('/campaigns')->with('success', 'Campaign deleted!');
    }
}
