<?php

namespace App\Http\Controllers;

use App\Models\AreaOfInterest;
use App\Models\TargetDemographic;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('list', User::class);

        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);

        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = new User([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->save();

        return back()->with('success', 'User created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'username' => ['sometimes', 'string', 'max:255', 'unique:users'],
            'email' => ['sometimes', 'string', 'max:255', 'unique:users'],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return back()->with('success', 'User deleted!');
    }

    public function assignTargetDemographics(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'targetDemographics' => ['required','array'],
            'targetDemographics.*' => ['exists:target_demographics,id'],
        ]);

        $existingTargetDemoIds = $user->targetDemographics()->pluck('target_demographics.id')->all();

        $user->targetDemographics()->sync(array_unique(array_merge($existingTargetDemoIds, $validated['targetDemographics'])));

        $user->save();

        return back()->with('success', 'Target demographics assigned to user!');
    }

    public function unassignTargetDemographic(User $user, TargetDemographic $targetDemographic)
    {
        $this->authorize('update', $user);

        $user->targetDemographics()->detach($targetDemographic);

        return back();
    }

    public function assignAreasOfInterest(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'areasOfInterest' => ['required','array'],
            'areasOfInterest.*' => ['exists:area_of_interests,id'],
        ]);

        $existingAreaOfInterestIds = $user->areasOfInterest()->pluck('area_of_interests.id')->all();
        $user->areasOfInterest()->sync(array_unique(array_merge($existingAreaOfInterestIds, $validated['areasOfInterest'])));

        $user->save();

        return back();
    }

    public function unassignAreaOfInterest(User $user, AreaOfInterest $areaOfInterest)
    {
        $this->authorize('update', $user);

        $user->areasOfInterest()->detach($areaOfInterest);

        return back();
    }
}
