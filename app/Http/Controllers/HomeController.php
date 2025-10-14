<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $assignedActivities = $user->activities()->get();
        $steps = $user->steps()->get();
        $stepIds = $steps->pluck('id');
        $ownedActivities = Activity::whereIn('step_id', $stepIds)->get();
        $campaigns = $user->campaigns()->get();
        $themes = $user->themes()->get();

        return view('home', compact('assignedActivities', 'steps', 'ownedActivities', 'campaigns', 'themes'));
    }
}
