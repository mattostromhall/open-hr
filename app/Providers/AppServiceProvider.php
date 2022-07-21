<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::enforceMorphMap([
            'application' => 'Domain\Recruitment\Models\Application',
            'expense' => 'Domain\Expenses\Models\Expense',
            'organisation' => 'Domain\Organisation\Models\Organisation',
            'person' => 'Domain\People\Models\Person',
            'user' => 'Domain\Auth\Models\User',
            'vacancy' => 'Domain\Recruitment\Models\Vacancy'
        ]);

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }
}
