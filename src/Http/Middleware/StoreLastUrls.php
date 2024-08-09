<?php

namespace Yagnesh\UrlHistoryTracker\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class StoreLastUrls
{
    public function handle($request, Closure $next)
    {
        // Skip tracking if the request is an AJAX request
        if ($request->ajax()) {
            return $next($request);
        }

        $currentUrl = $request->fullUrl();
        $lastUrls = Session::get('last_urls', []);

        if (empty($lastUrls) || end($lastUrls) !== $currentUrl) {
            $lastUrls[] = $currentUrl;

            if (count($lastUrls) > config('urlhistorytracker.url_limit')) {
                array_shift($lastUrls);
            }

            Session::put('last_urls', $lastUrls);
        }

        return $next($request);
    }

    public static function getSecondLastUrl()
    {
        $lastUrls = Session::get('last_urls', []);
        
        // Pop the first URL
        array_shift($lastUrls);
        // \Log::info($lastUrls);

        // Return the second URL in the remaining list
        return isset($lastUrls[1]) ? $lastUrls[1] : null;
    }
}
