<?php

namespace Tug;

use Illuminate\Support\ServiceProvider;

class TugServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->publishes([
            TUG_PATH.'/files/docker' => base_path('docker'),
            TUG_PATH.'/files/docker-compose.yml' => base_path('docker-compose.yml'),
            TUG_PATH.'/files/tug' => base_path('tug'),
        ]);
    }

    public function register()
    {
        if (! defined('TUG_PATH')) {
            define('TUG_PATH', realpath(__DIR__.'/../'));
        }
    }

}