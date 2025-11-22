<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use App\Models\AreaOfInterest;
use App\Models\InformationSource;
use App\Models\TargetDemographic;
use App\Models\Theme;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( auth()->user()->hasRole(RolesEnum::SYSADMIN->value)){
            $themes = Theme::all();
            return view('theme.index', [
                'themes' => $themes
            ]);
        }

        $this->authorize('viewAny', Theme::class);

        $themes = Theme::all();
        return view('theme.index', ['themes' => $themes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Theme::class);

        return view('theme.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Theme::class);

        $theme = $request->validate([
            'name' => ['required','string'],
            'description' => ['string','nullable']
        ]);

        Theme::create($theme);

        return redirect('/themes')->with('success', 'Theme created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Theme $theme)
    {
        $this->authorize('view', $theme);

        return view('theme.detail', compact('theme'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Theme $theme)
    {
        $this->authorize('update', $theme);

        return view('theme.edit', compact('theme'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Theme $theme)
    {
        $this->authorize('update', $theme);

        $validated = $request->validate([
            'name' => ['required','string'],
            'description' => ['string','nullable']
        ]);

        $theme->update($validated);

        return redirect('/themes')->with('success', 'Theme updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theme $theme)
    {
        $this->authorize('delete', $theme);

        $theme->delete();

        return redirect('/themes')->with('success', 'Theme deleted!');
    }

    public function assignTargetDemographics(Request $request, Theme $theme)
    {
        $this->authorize('update', $theme);

        $validated = $request->validate([
            'targetDemographics' => ['required','array'],
            'targetDemographics.*' => ['exists:target_demographics,id'],
        ]);

        $existingTargetDemoIds = $theme->targetDemographics()->pluck('target_demographics.id')->all();

        $theme->targetDemographics()->sync(array_unique(array_merge($existingTargetDemoIds, $validated['targetDemographics'])));

        $theme->save();

        return back()->with('success', 'Target demographics assigned to theme!');
    }

    public function unassignTargetDemographic(Theme $theme, TargetDemographic $targetDemographic)
    {
        $this->authorize('update', $theme);

        $theme->targetDemographics()->detach($targetDemographic);

        return back()->with('success', 'Target demographic unassigned from theme!');
    }

    public function assignAreasOfInterest(Request $request, Theme $theme)
    {
        $this->authorize('update', $theme);

        $validated = $request->validate([
            'areasOfInterest' => ['required','array'],
            'areasOfInterest.*' => ['exists:area_of_interests,id'],
        ]);

        $existingAreaOfInterestIds = $theme->areasOfInterest()->pluck('area_if_interests.id')->all();

        $theme->targetDemographics()->sync(array_unique(array_merge($existingAreaOfInterestIds, $validated['targetDemographics'])));

        $theme->save();

        return back()->with('success', 'Areas of interest assigned to activity!');
    }

    public function unassignAreaOfInterest(Theme $theme, AreaOfInterest $areaOfInterest)
    {
        $this->authorize('update', $theme);

        $theme->areasOfInterest()->detach($areaOfInterest);

        return back()->with('success', 'Area of interest unassigned from theme!');
    }

    public function assignInformationSources(Request $request, Theme $theme)
    {
        $this->authorize('update', $theme);

        $validated = $request->validate([
            'informationSources' => ['required','array'],
            'informationSources.*' => ['exists:information_sources,id'],
        ]);

        $existingInformationSourceIds = $theme->informationSources()->pluck('information_sources.id')->all();

        $theme->targetDemographics()->sync(array_unique(array_merge($existingInformationSourceIds, $validated['informationSources'])));

        $theme->save();

        return back()->with('success', 'Information sources assigned to activity!');
    }

    public function unassignInformationSource(Theme $theme, InformationSource $informationSource)
    {
        $this->authorize('update', $theme);

        $theme->informationSources()->detach($informationSource);

        return back()->with('success', 'Information source unassigned from theme!');
    }
}
