<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user(); 
        $assignedActivities = $user->activities()->get();


        $steps = $user->getSteps();
        $stepIds = $steps->pluck('id');
        $ownedActivities = Activity::whereIn('step_id', $stepIds)->get();
        $campaigns = $user->campaigns()->get();
        $themes = $user->themes()->get();

            
        
        return view('home', compact('assignedActivities', 'steps', 'ownedActivities', 'campaigns', 'themes'));
    }

    
}
