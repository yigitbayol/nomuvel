<?php

namespace Yigitbayol\Nomuvel;

use Illuminate\Support\ServiceProvider;
use Yigitbayol\Nomuvel\Providers\ConfigServiceProvider;

class NomuvelServiceProvider extends ServiceProvider
{
    function boot()
    {

    }

    function register(): void
    {
        $this->app->register(ConfigServiceProvider::class);
    }
}
