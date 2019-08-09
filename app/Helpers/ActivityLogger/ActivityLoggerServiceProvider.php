<?php

namespace App\Helpers\ActivityLogger;

use Illuminate\Support\ServiceProvider;

class ActivityLoggerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(
            'App\Helpers\ActivityLogger\Contracts\ActivityLoggerInterface', function ($app) {
                return new \App\Helpers\ActivityLogger\ActivityFileLogger;
            }
        );
    }
}