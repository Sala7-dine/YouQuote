<?php

namespace App\Providers;

use App\Models\Quote;
use App\Models\Category;
use App\Policies\QuotePolicy;
use App\Policies\CategoryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Quote::class => QuotePolicy::class,
        Category::class => CategoryPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
