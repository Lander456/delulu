<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
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

        return back()->with('success', 'Users assigned to campaign');
    }
}
