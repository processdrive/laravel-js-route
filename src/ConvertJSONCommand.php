<?php

namespace ProcessDrive\LaravelJsRoute;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;


class ConvertJSONCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route:json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert all route to json';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $routes = $this->generateRoutes();
        $this->writeJson($routes);
        return;
    }

    /**
     * Get all route using laravel method and convert to the array 
     */
    public function generateRoutes()
    {
        $routes = [];
        $routeCollection = \Route::getRoutes();
        foreach ($routeCollection as $key => $value) {
            $routes[str_replace(".", "", @$value->getName() ? $value->getName() : $value->uri)] = $value->uri;
        }
        return $routes;
    }

    /**
     * Write the file
     */
    protected function writeJson($routes)
    {
        $filename = storage_path().'/routes.json';
        if (!$handle = fopen($filename, 'w')) {
            $this->error("Cannot open file: $filename");
            return;
        }

        // Write $somecontent to our opened file.
        if (fwrite($handle, json_encode($routes)) === false) {
            $this->error("Cannot write to file: $filename");
            return;
        }
        $this->info("Wrote routes to: $filename");
        fclose($handle);
    }
}
