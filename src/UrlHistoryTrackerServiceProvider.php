<?php

namespace Yagnesh\UrlHistoryTracker;

use Illuminate\Support\ServiceProvider;
use Yagnesh\UrlHistoryTracker\Http\Middleware\StoreLastUrls;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

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

        // Define the macro on the Redirect facade
        Redirect::macro('getLastUrl', function ($position = 2) {
        $lastUrls = Session::get('last_urls', []);

            // Pop the first URL to maintain the existing functionality
            array_shift($lastUrls);

            // Return the URL at the specified position, if it exists
            return isset($lastUrls[$position - 1]) ? $lastUrls[$position - 1] : null;
        });
    }

    public function register()
    {
        // Merge the package configuration with the app's published configuration
        $this->mergeConfigFrom(__DIR__.'/../config/urlhistorytracker.php', 'urlhistorytracker');
    }
}
