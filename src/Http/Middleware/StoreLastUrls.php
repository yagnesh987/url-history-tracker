<?php

namespace Yagnesh\UrlHistoryTracker\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class StoreLastUrls
{
    public function handle($request, Closure $next)
    {
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
        return $lastUrls[count($lastUrls) - 2] ?? null;
    }
}
