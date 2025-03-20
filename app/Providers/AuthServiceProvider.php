<?php

namespace App\Providers;

use App\Models\Quote;
use App\Models\Category;
use App\Models\Tag;
use App\Policies\QuotePolicy;
use App\Policies\CategoryPolicy;
use App\Policies\TagPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Quote::class => QuotePolicy::class,
        Category::class => CategoryPolicy::class,
        Tag::class => TagPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
