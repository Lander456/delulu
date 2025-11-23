<?php

namespace App\Http\Controllers;

use App\Models\InformationSource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\User;


class InformationSourceController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {   

        $sources = InformationSource::all();
        return view('informationSource.index', ['sources' => $sources]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', InformationSource::class);

        return view('informationSource.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', InformationSource::class);

        $informationSource = $request->validate([
            'name' => ['required','string'],
            'description' => ['nullable','string','max:65535'],
        ]);

        InformationSource::create($informationSource);

        return redirect('/informationSources');
    }

    /**
     * Display the specified resource.
     */
    public function show(InformationSource $informationSource)
    {
        $this->authorize('view', $informationSource);

        return view('informationSource.detail', compact('informationSource'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InformationSource $informationSource)
    {
        $this->authorize('update', $informationSource);
        $users = User::all();
        return view('informationSource.edit', compact('informationSource', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InformationSource $informationSource)
    {
        $this->authorize('update', $informationSource);

        $validated = $request->validate([
            'name' => ['required','string'],
            'description' => ['nullable','string','max:65535'],
        ]);

        $informationSource->update($validated);

        return view('informationSource.detail', compact('informationSource'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InformationSource $informationSource)
    {
        $this->authorize('delete', $informationSource);

        $informationSource->delete();

        return redirect('/informationSources');
    }
}
