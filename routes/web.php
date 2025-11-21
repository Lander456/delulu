<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CampaignUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\ThemeController;
use App\Models\Activity;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login', ['title' => 'Register']);
});

Route::middleware('auth')->group(function (){

    Route::get('/home', [HomeController::class, 'index'])
    ->name('home');
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



Route::view('/activities', 'activity.index');

Route::put('/activities/{activity}/users', [ActivityController::class, 'assignUsers'])->name('activities.assignUsers');

Route::delete('/activities/{activity}/users/{user}', [ActivityController::class, 'unassignUser'])->name('activities.unassignUser');

Route::resource('activities', ActivityController::class);

Route::resource('steps', StepController::class);

Route::put('steps/{step}/activities', [StepController::class, 'assignActivity'])->name('steps.assignActivities');

Route::delete('/steps/{step}/activities/{activity}', [StepController::class, 'unassignActivity'])->name('steps.unassignActivities');

Route::resource('campaigns', CampaignController::class);

Route::put('/campaigns/{campaign}/users', [CampaignUserController::class, 'assignUsers'])->name('campaigns.assignUsers');

Route::resource('themes', ThemeController::class);

Route::post('/activities/{activity}/request', [\App\Http\Controllers\ActivityRequestController::class, 'storeRequest'])->name('activities.request')->middleware('auth');

Route::post('/logout', Logout::class)
    ->middleware('auth')
    ->name('logout');
