<?php

namespace App\Providers;

use App\Models\User;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ViewServiceProvider extends ServiceProvider
{
    use AuthorizesRequests;
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('components.layout', function ($view) {
            $userCampaigns = auth()->user()->getCampaigns();
            $view->with('userCampaigns', $userCampaigns);
        });
    }
}
