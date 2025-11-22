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
        $campaigns = $user->getCampaigns();
        $themes = $user->themes()->get();

            
        
        return view('home', compact('assignedActivities', 'steps', 'campaigns', 'themes'));
    }

    
}
