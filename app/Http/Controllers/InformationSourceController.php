<?php

namespace App\Http\Controllers;

use App\Models\InformationSource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;


class InformationSourceController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $sources = InformationSource::all();
        return view('informationSource.index', ['informationSource' => $sources]);

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
            'description' => 'string',
        ]);

        InformationSource::create($informationSource);

        return redirect('/informationsources')->with('success', 'Information source added!');
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

        return view('informationSource.edit', compact('informationSource'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InformationSource $informationSource)
    {
        $this->authorize('update', $informationSource);

        $validated = $request->validate([
            'name' => ['required','string'],
            'description' => ['string'],
        ]);

        $informationSource->update($validated);

        return redirect('/informationsources')->with('success', 'Information source updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InformationSource $informationSource)
    {
        $this->authorize('delete', $informationSource);

        $informationSource->delete();
    }
}
