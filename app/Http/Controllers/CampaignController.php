<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Campaign;
use App\Models\AreaOfInterest;
use App\Models\InformationSource;
use App\Models\TargetDemographic;
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

        $themes = Theme::all();
        $users = User::all();
        return view('campaign.create', compact('themes', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Campaign::class);

        $campaign = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable','string','max:65535'],
            'theme_id' => ['required', 'exists:themes,id'],
            'user_id' => ['required', 'exists:users,id'],
            'current_step_id' => ['nullable','exists:steps,id'],
        ]);

        Campaign::create($campaign);

        $theme = Theme::find($campaign['theme_id']);
        $areasOfInterest = AreaOfInterest::whereNotIn('id', $theme->areasOfInterest->pluck('id'))->get();
        $targetDemographics = TargetDemographic::whereNotIn('id', $theme->targetDemographics->pluck('id'))->get();
        $informationSources = InformationSource::whereNotIn('id', $theme->informationSources->pluck('id'))->get();
        return redirect()->route('themes.show', compact('theme', 'areasOfInterest', 'targetDemographics', 'informationSources'));;
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        $this->authorize('view', $campaign);

        $assignedUserIds = $campaign->users->pluck('id');

        $users = User::whereNotIn('id', $assignedUserIds)
            ->get();
        return view('campaign.detail', compact('campaign', 'users'));
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
        $assignedUserIds = $campaign->users->pluck('id');

        $users = User::whereNotIn('id', $assignedUserIds)
            ->get();
        return view('campaign.detail', compact('campaign', 'users'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        $this->authorize('delete', $campaign);

        $campaign->delete();

        return redirect('/campaigns');
    }
}
