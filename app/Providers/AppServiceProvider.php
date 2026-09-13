<?php

namespace App\Providers;

use App\Models\Berita;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Data navbar & ticker untuk layout publik
        View::composer('layouts.public', function ($view) {
            $view->with('navCategories', Category::orderBy('name')->take(8)->get());
            $view->with('tickerItems', Berita::published()->latest('published_at')->take(6)->get(['title']));
        });
    }
}
