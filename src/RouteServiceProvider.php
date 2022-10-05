<?php

namespace ProcessDrive\LaravelJsRoute;

use Illuminate\Support\ServiceProvider;
use ProcessDrive\LaravelJsRoute\ConvertJSONCommand;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__, 'LaravelJsRoute');
        $this->commands([
            ConvertJSONCommand::class
        ]);
    }
}
