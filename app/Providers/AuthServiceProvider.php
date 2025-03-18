<?php

namespace App\Providers;

use App\Models\Quote;
use App\Policies\QuotePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Quote::class => QuotePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
