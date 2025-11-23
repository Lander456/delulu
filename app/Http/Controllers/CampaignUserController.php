<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CampaignUserController extends Controller
{
    use AuthorizesRequests;
    public function assignUsers(Request $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $validated = $request->validate([
            'users' => ['required', 'array'],
            'users.*' => ['exists:users,id']
        ]);

        $campaign->users()->syncWithoutDetaching($validated['users']);

        return back();
    }

    public function unassignUser(Campaign $campaign, User $user)
    {
        $campaign->users()->detach($user);

        return back();
    }
}
