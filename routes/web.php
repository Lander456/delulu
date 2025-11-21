<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\ThemeController;
use App\Models\Activity;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.register');
});

Route::view('/login', 'auth.login')
    ->middleware('guest')
    ->name('login');

Route::get('/register', function() {
    return view('auth.register');
})->middleware('guest');

Route::post('/register', Register::class)
    ->middleware('guest');

Route::post('login', Login::class);

Route::get('/home', [HomeController::class, 'index'])
    ->name('home');

Route::view('/activities', 'activity.index');

Route::put('/activities/{activity}/users', [ActivityController::class, 'assignUsers'])->name('activities.assignUsers');

Route::delete('/activities/{activity}/users/{user}', [ActivityController::class, 'unassignUser'])->name('activities.unassignUser');

Route::resource('activities', ActivityController::class);

Route::resource('steps', StepController::class);

Route::put('steps/{step}/activities', [StepController::class, 'assignActivity'])->name('steps.assignActivities');

Route::delete('/steps/{step}/activities/{activity}', [StepController::class, 'unassignActivity'])->name('steps.unassignActivities');

Route::resource('campaigns', CampaignController::class);

Route::resource('themes', ThemeController::class);

Route::post('/logout', Logout::class)
    ->middleware('auth')
    ->name('logout');
