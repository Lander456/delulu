<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ActivityRequestController extends Controller
{
    use AuthorizesRequests;
    public function storeRequest(Request $request, Activity $activity)
    {
        $user = $request->user();

        $campaign = $activity->step->campaign;

        if (!$campaign->users->contains($user)) {
            abort(403, 'You are not assigned to this campaign');
        }

        if ($activity->activityRequests()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'You have already requested to be assigned to this activity');
        }

        $activity->activityRequests()->create([
            'user_id' => $user->id,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Request for assignment submitted successfully');
    }

    public function approve(ActivityRequest $request)
    {
        $this->authorize('update', $request->activity);

        $request->update(['status' => 'approved']);

        $request->activity->users()->attach($request->user_id);

        return back()->with('success', 'Request approved');
    }

    public function reject(ActivityRequest $request)
    {
        $this->authorize('update', $request->activity);

        $request->update(['status' => 'rejected']);

        return back()->with('success', 'Request rejected');
    }
}
