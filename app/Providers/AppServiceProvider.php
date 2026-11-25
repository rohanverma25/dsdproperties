<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Retry a missing app view for ~2 s, so pages don't 500 while hPanel Git Deploy is replacing files.
        $this->app->bind('view.finder', function ($app) {
            return new \App\View\RetryingFileViewFinder($app['files'], $app['config']['view.paths']);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // config/author.php was added 18 Nov 2026. If production runs with a cached config built before that, the key is
        // missing and bylines/blog pages would break, so load the file directly in that case.
        if (! config('author.name') && file_exists(config_path('author.php'))) {
            config(['author' => require config_path('author.php')]);
        }
    }
}
