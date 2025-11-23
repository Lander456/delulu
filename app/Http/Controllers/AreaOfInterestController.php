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
        $this->authorize('viewAny', AreaOfInterest::class);
        $areas = AreaOfInterest::all();
        return view('areaofinterest.index', ['areas' => $areas]);
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
        $this->authorize('create', AreaOfInterest::class);

        $areaOfInterest = $request->validate([
            'name' => ['required','string'],
            'description' => ['nullable','string','max:65535'],
            'relevance' => ['string']
        ]);

        AreaOfInterest::create($areaOfInterest);

        return redirect('/areasOfInterest');
    }

    /**
     * Display the specified resource.
     */
    public function show(AreaOfInterest $areasOfInterest)
    {
        $this->authorize('view', $areasOfInterest);
        return view('areaofinterest.detail', compact('areasOfInterest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AreaOfInterest $areasOfInterest)
    {
        $this->authorize('update', $areasOfInterest);

        return view('areaofinterest.edit', compact('areasOfInterest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AreaOfInterest $areasOfInterest)
    {
        $this->authorize('update', $areasOfInterest);

        $validated = $request->validate([
            'name' => ['required','string'],
            'description' => ['nullable','string','max:65535'],
            'relevance' => ['string']
        ]);

        $areasOfInterest->update($validated);

        return view('areaofinterest.detail', compact('areasOfInterest'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AreaOfInterest $areasOfInterest)
    {
        $this->authorize('delete', $areasOfInterest);

        $areasOfInterest->delete();

        return redirect('/areasOfInterest');
    }
}
