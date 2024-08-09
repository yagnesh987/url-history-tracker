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
        Redirect::macro('getSecondLastUrl', function () {
            $lastUrls = Session::get('last_urls', []);

            // Pop the first URL
            array_shift($lastUrls);

            // Return the second URL in the remaining list
            return isset($lastUrls[1]) ? $lastUrls[1] : null;
        });
    }

    public function register()
    {
        // Merge the package configuration with the app's published configuration
        $this->mergeConfigFrom(__DIR__.'/../config/urlhistorytracker.php', 'urlhistorytracker');
    }
}
