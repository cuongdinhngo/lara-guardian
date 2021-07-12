<?php

namespace Cuongnd88\LaraGuardian;

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
            Commands\MakeGuardianCommand::class,
            Commands\GuardianCommand::class,
        ]);
    }
}