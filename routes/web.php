<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityRequestController;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CampaignUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AreaOfInterestController;
use App\Http\Controllers\TargetDemographicController;
use App\Http\Controllers\InformationSourceController;
use App\Models\Activity;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login', ['title' => 'Register']);
});

Route::middleware('auth')->group(function (){

    Route::get('/home', [HomeController::class, 'index'])
    ->name('home');
    Route::view('/activities', 'activity.index');

    Route::put('/activities/{activity}/users', [ActivityController::class, 'assignUsers'])->name('activities.assignUsers');

    Route::delete('/activities/{activity}/users/{user}', action: [ActivityController::class, 'unassignUser'])->name('activities.unassignUser');

    Route::patch('/activities/{activity}/complete', [ActivityController::class, 'complete'])->name('activities.complete')->middleware('auth');

    Route::patch('/activities/{activity}/mark', [ActivityController::class, 'mark'])->name('activities.mark');

    Route::post('/activities/{activity}/request', [ActivityRequestController::class, 'storeRequest'])->name('activities.request')->middleware('auth');

    Route::patch('/activities/{activityRequest}/approve', [activityRequestController::class, 'approve'])->name('activityRequest.approve')->middleware('auth');

    Route::patch('/activities/{activityRequest}/reject', [activityRequestController::class, 'reject'])->name('activityRequest.reject')->middleware('auth');
    
    Route::resource('activities', ActivityController::class);

    Route::resource('steps', StepController::class);

    Route::put('steps/{step}/activities', [StepController::class, 'assignActivity'])->name('steps.assignActivities');

    Route::delete('/steps/{step}/activities/{activity}', [StepController::class, 'unassignActivity'])->name('steps.unassignActivities');


    Route::put('/campaigns/{campaign}/users', [CampaignUserController::class, 'assignUsers'])->name('campaigns.assignUsers');

    Route::resource('campaigns', CampaignController::class);

    Route::delete('/campaigns/{campaign}/users/{user}', [CampaignUserController::class, 'unassignUser'])->name('campaigns.unassignUser');

    Route::put('/themes/{theme}/TargetDemographics', [ThemeController::class, 'assignTargetDemographics'])->name('themes.assignTargetDemographics');

    Route::put('/themes/{theme}/AreasOfInterest', [ThemeController::class, 'assignAreasOfInterest'])->name('themes.assignAreasOfInterest');

    Route::put('/themes/{theme}/InformationSources', [ThemeController::class, 'assignInformationSources'])->name('themes.assignInformationSources');

    Route::delete('/themes/{theme}/TargetDemographics/{targetDemographic}', [ThemeController::class, 'unassignTargetDemographic'])->name('themes.unassignTargetDemographic');

    Route::delete('/themes/{theme}/AreasOfInterest/{areaOfInterest}', [ThemeController::class, 'unassignAreaOfInterest'])->name('themes.unassignAreaOfInterest');

    Route::delete('/themes/{theme}/InformationSources/{informationSource}', [ThemeController::class, 'unassignInformationSource'])->name('themes.unassignInformationSource');

    Route::resource('themes', ThemeController::class);

    Route::put('/users/{user}/TargetDemographics', [UserController::class, 'assignTargetDemographics'])->name('users.assignTargetDemographics');

    Route::put('users/{user}/AreasOfInterest', [UserController::class, 'assignAreasOfInterest'])->name('users.assignAreasOfInterest');

    Route::delete('users/{user}/TargetDemographics/{targetDemographic}', [UserController::class, 'unassignTargetDemographic'])->name('users.unassignTargetDemographic');

    Route::delete('users/{user}/AreasOfInterest/{areaOfInterest}', [UserController::class, 'unassignAreaOfInterest'])->name('users.unassignAreaOfInterest');

    Route::resource('users', controller: UserController::class);

    Route::resource('areasOfInterest', AreaOfInterestController::class);

    Route::resource('targetDemographics', TargetDemographicController::class);

    Route::resource('informationSources', InformationSourceController::class);
});

Route::middleware('guest')->group(function (){

    Route::view('/login', 'auth.login', ['title' => 'Login'])
    ->name('login');
    Route::get('/register', function() {
        return view('auth.register');
    });
    Route::post('/register', action: Register::class);

});






Route::post('login', Login::class);


Route::post('/logout', Logout::class)
    ->middleware('auth')
    ->name('logout');
