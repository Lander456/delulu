<?php

namespace App\Http\Controllers;

use App\Models\TargetDemographic;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TargetDemographicController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('list', TargetDemographic::class);

        $demos = TargetDemographic::all();
        return view('targetDemographics.index', ['targetDemographics' => $demos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', TargetDemographic::class);

        return view('target-demographic.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', TargetDemographic::class);

        $targetDemographic = $request->validate([
            'name' => ['required','string'],
            'amount' => ['integer'],
            'description' => ['nullable','string','max:65535'],
            'difficulty' => ['integer'],
            'ethics' => ['string'],
            'relevance' => ['integer']
        ]);

        TargetDemographic::create($targetDemographic);

        return redirect('/targetDemographics')->with('success', 'Target demographic created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TargetDemographic $targetDemographic)
    {
        $this->authorize('view', $targetDemographic);

        return view('target-demographic.detail', compact('targetDemographic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TargetDemographic $targetDemographic)
    {
        $this->authorize('update', $targetDemographic);

        return view('target-demographic.edit', compact('targetDemographic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TargetDemographic $targetDemographic)
    {
        $this->authorize('update', $targetDemographic);

        $validated = $request->validate([
            'name' => ['required','string'],
            'amount' => ['integer'],
            'description' => ['nullable','string','max:65535'],
            'difficulty' => ['integer'],
            'ethics' => ['string'],
            'relevance' => ['integer']
        ]);

        $targetDemographic->update($validated);

        return redirect('/targetDemographics')->with('success', 'Target demographic updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TargetDemographic $targetDemographic)
    {
        $this->authorize('delete', $targetDemographic);

        $targetDemographic->delete();

        return redirect('/targetDemographics')->with('success', 'Target demographic deleted!');
    }
}
