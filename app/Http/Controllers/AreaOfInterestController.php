<?php

namespace App\Http\Controllers;

use App\Models\AreaOfInterest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AreaOfInterestController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AreaOfInterest::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', AreaOfInterest::class);

        return view('areaofinterest.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $areaOfInterest = $request->validate([
            'name' => ['required','string'],
            'description' => ['string'],
            'relevance' => ['string']
        ]);

        AreaOfInterest::create($areaOfInterest);

        return redirect('/areasOfInterest')->with('success', 'Activity created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AreaOfInterest $areaOfInterest)
    {
        return view('areaofinterest.detail', compact('areaOfInterest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AreaOfInterest $areaOfInterest)
    {
        $this->authorize('update', $areaOfInterest);

        return view('areaofinterest.edit', compact('areaOfInterest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AreaOfInterest $areaOfInterest)
    {
        $this->authorize('update', $areaOfInterest);

        $validated = $request->validate([
            'name' => ['required','string'],
            'description' => ['string'],
            'relevance' => ['string']
        ]);

        $areaOfInterest->update($validated);

        return redirect('/areasOfInterest')->with('success', 'Activity updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AreaOfInterest $areaOfInterest)
    {
        $this->authorize('delete', $areaOfInterest);

        $areaOfInterest->delete();

        return redirect('/areasOfInterest')->with('success', 'Activity deleted!');
    }
}
