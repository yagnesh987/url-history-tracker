<?php

namespace Yagnesh\UrlHistoryTracker;

use Illuminate\Support\ServiceProvider;
use Yagnesh\UrlHistoryTracker\Http\Middleware\StoreLastUrls;

class UrlHistoryTrackerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish configuration file
        $this->publishes([
            __DIR__.'/../config/urlhistorytracker.php' => config_path('urlhistorytracker.php'),
        ], 'config');

        // Register the middleware globally
        $this->app['router']->pushMiddlewareToGroup('web', StoreLastUrls::class);
    }

    public function register()
    {
        // Merge the package configuration with the app's published configuration
        $this->mergeConfigFrom(__DIR__.'/../config/urlhistorytracker.php', 'urlhistorytracker');
    }
}
