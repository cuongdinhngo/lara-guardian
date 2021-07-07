<?php

namespace Cuongnd88\LaraGuardian;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class LaraGuardianServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            \Cuongnd88\LaraGuardian\Commands\MakeGuardianCommand::class,
        ]);
    }
}