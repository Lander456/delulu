<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
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
        $this->authorize('list', Theme::class);

        $user = auth()->user();
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
}
