<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
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
        if (App::environment('production')) {
            \URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            if (auth()->check()) {
                $view->with('userSettings', [
                    'theme' => auth()->user()->theme,
                    'language' => auth()->user()->language,
                ]);
            }
        });
    }
}
