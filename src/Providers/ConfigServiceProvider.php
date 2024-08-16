<?php

namespace Yigitbayol\Nomuvel\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../Config/nomuvel.php' => config_path('nomuvel.php')
        ], 'nomuvel-config');
    }
}
