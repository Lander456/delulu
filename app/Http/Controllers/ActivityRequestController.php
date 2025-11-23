<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Notifications\Action;

class ActivityRequestController extends Controller
{
    use AuthorizesRequests;
    public function storeRequest(Request $request, Activity $activity)
    {
        $user = $request->user();

        $campaign = $activity->step->campaign;

        if ($activity->activityRequests()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'You have already requested to be assigned to this activity');
        }

        $activity->activityRequests()->create([
            'user_id' => $user->id,
            'status' => 'pending',
            'activity_id' => $activity->id
        ]);

        return redirect()->route('activities.show', compact('activity'));
    }

    public function approve(ActivityRequest $activityRequest)
    {
        $activity = $activityRequest->activity;
        

        $this->authorize('update', $activity);

        $activity->users()->attach($activityRequest->user_id);
        $activityRequest->delete();
        return back();
    }

    public function reject(ActivityRequest $activityRequest)
    {
        $activity = $activityRequest->activity;
        $this->authorize('update', $activity);

        $activityRequest->delete();
        return back();
    }
}
