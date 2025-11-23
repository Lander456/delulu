<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use App\Models\AreaOfInterest;
use App\Models\InformationSource;
use App\Models\TargetDemographic;
use App\Models\Theme;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\User;

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

        $users = User::all();
        return view('theme.create', compact( 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Theme::class);

        $theme = $request->validate([
            'name' => ['required','string'],
            'description' => ['nullable','string','max:65535'],
            'user_id' => ['nullable','exists:users,id']
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

        $areasOfInterest = AreaOfInterest::whereNotIn('id', $theme->areasOfInterest->pluck('id'))->get();
        $targetDemographics = TargetDemographic::whereNotIn('id', $theme->targetDemographics->pluck('id'))->get();
        $informationSources = InformationSource::whereNotIn('id', $theme->informationSources->pluck('id'))->get();
        return view('theme.detail', 
        compact('theme', 'areasOfInterest', 'targetDemographics', 'informationSources'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Theme $theme)
    {
        $this->authorize('update', $theme);
        $areasOfInterest = AreaOfInterest::whereNotIn('id', $theme->areasOfInterest->pluck('id'))->get();
        $targetDemographics = TargetDemographic::whereNotIn('id', $theme->targetDemographics->pluck('id'))->get();
        $informationSources = InformationSource::whereNotIn('id', $theme->informationSources->pluck('id'))->get();
        $users = User::all();
        return view('theme.edit', compact('theme', 'users', 'areasOfInterest', 'targetDemographics', 'informationSources'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Theme $theme)
    {
        $this->authorize('update', $theme);

        $validated = $request->validate([
            'name' => ['required','string'],
            'description' => ['nullable','string','max:65535'],
            'user_id' => ['nullable','exists:users,id']
        ]);

        $areasOfInterest = AreaOfInterest::whereNotIn('id', $theme->areasOfInterest->pluck('id'))->get();
        $targetDemographics = TargetDemographic::whereNotIn('id', $theme->targetDemographics->pluck('id'))->get();
        $informationSources = InformationSource::whereNotIn('id', $theme->informationSources->pluck('id'))->get();

        $theme->update($validated);

        return view('theme.detail', compact('theme', 'areasOfInterest', 'targetDemographics', 'informationSources'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theme $theme)
    {
        $this->authorize('delete', $theme);

        $theme->delete();

        return redirect('/themes');
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

        return back();
    }

    public function assignAreasOfInterest(Request $request, Theme $theme)
    {
        $this->authorize('update', $theme);

        $validated = $request->validate([
            'areasOfInterest' => ['required','array'],
            'areasOfInterest.*' => ['exists:area_of_interests,id'],
        ]);

        $existingAreaOfInterestIds = $theme->areasOfInterest()->pluck('area_of_interests.id')->all();
        $theme->areasOfInterest()->sync(array_unique(array_merge($existingAreaOfInterestIds, $validated['areasOfInterest'])));
        
        $theme->save();

        return back();
    }

    public function unassignAreaOfInterest(Theme $theme, AreaOfInterest $areaOfInterest)
    {
        $this->authorize('update', $theme);

        $theme->areasOfInterest()->detach($areaOfInterest);

        return back();
    }

    public function assignInformationSources(Request $request, Theme $theme)
    {
        $this->authorize('update', $theme);

        $validated = $request->validate([
            'informationSources' => ['required','array'],
            'informationSources.*' => ['exists:information_sources,id'],
        ]);

        $existingInformationSourceIds = $theme->informationSources()->pluck('information_sources.id')->all();

        $theme->informationSources()->sync(array_unique(array_merge($existingInformationSourceIds, $validated['informationSources'])));

        $theme->save();

        return back();
    }

    public function unassignInformationSource(Theme $theme, InformationSource $informationSource)
    {
        $this->authorize('update', $theme);

        $theme->informationSources()->detach($informationSource);

        return back();
    }
}
