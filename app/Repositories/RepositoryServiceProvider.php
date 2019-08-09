<?php
namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        /* $this->app->bind(
            'App\Repositories\Contracts\TodoListRepositoryInterface',
            'App\Repositories\TodoListRepository'
        ); */
        $this->app->singleton(
            'App\Repositories\Contracts\TodoListRepositoryInterface', function ($app) {
                return new \App\Repositories\TodoListRepository(
                    $app->make('App\Helpers\ActivityLogger\Contracts\ActivityLoggerInterface')
                );
            }
        );
    }
}