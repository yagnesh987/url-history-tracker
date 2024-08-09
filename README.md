# Url History Tracker

`url-history-tracker` is a Laravel package that tracks the last few URLs visited by a user during their session. It allows you to easily access these URLs, providing a handy way to redirect users back to a previous page or perform other actions based on their navigation history.

## Features

- Tracks the last N URLs visited by the user (configurable).
- Provides a simple API to access the Nth last URL.
- Option to retrieve URLs by their position in history (e.g., 2nd last, 3rd last).

## Installation

You can install the package via Composer:

```bash
composer require yagnesh/url-history-tracker

# Publish

php artisan vendor:publish --tag=config --provider="Yagnesh\UrlHistoryTracker\UrlHistoryTrackerServiceProvider"

# Example:

use Illuminate\Support\Facades\Redirect;

// Get the 2nd last URL (default behavior)
$secondLastUrl = Redirect::getLastUrl();

// Get the 3rd last URL
$thirdLastUrl = Redirect::getLastUrl(3);

// Get the most recent URL (after the first one was popped)
$lastUrl = Redirect::getLastUrl(1);