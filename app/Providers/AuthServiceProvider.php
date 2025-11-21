<?php

namespace App\Providers;

use App\Models\Activity;
use App\Policies\ActivityPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Activity::class => ActivityPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
