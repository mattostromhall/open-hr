<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Support\Contracts\Services\ReportBuilderInterface;
use Support\Services\ReportBuilder;

class OpenHRServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ReportBuilderInterface::class, fn () => new ReportBuilder());
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
