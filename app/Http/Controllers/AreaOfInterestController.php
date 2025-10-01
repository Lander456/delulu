<?php

namespace App\Http\Controllers;

use App\Enums\PermissionsEnum;
use App\Models\AreaOfInterest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class AreaOfInterestController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize(PermissionsEnum::VIEW_AREAS_OF_INTEREST->value, AreaOfInterest::class);

        return AreaOfInterest::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize(PermissionsEnum::CREATE_AREAS_OF_INTEREST->value, AreaOfInterest::class);

        return view('areaofinterest.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize(PermissionsEnum::CREATE_AREAS_OF_INTEREST->value, AreaOfInterest::class);

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
        $this->authorize(PermissionsEnum::VIEW_AREAS_OF_INTEREST->value, AreaOfInterest::class);

        return view('areaofinterest.detail', compact('areaOfInterest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AreaOfInterest $areaOfInterest)
    {
        $this->authorize(PermissionsEnum::EDIT_AREAS_OF_INTEREST, AreaOfInterest::class);

        return view('areaofinterest.edit', compact('areaOfInterest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AreaOfInterest $areaOfInterest)
    {
        $this->authorize(PermissionsEnum::EDIT_AREAS_OF_INTEREST, $areaOfInterest);

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
        $this->authorize(PermissionsEnum::DELETE_AREAS_OF_INTEREST, $areaOfInterest);

        $areaOfInterest->delete();

        return redirect('/areasOfInterest')->with('success', 'Activity deleted!');
    }
}
