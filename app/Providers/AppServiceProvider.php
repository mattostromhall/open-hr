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
            'address' => 'Domain\People\Models\Address',
            'application' => 'Domain\Recruitment\Models\Application',
            'department' => 'Domain\Organisation\Models\Department',
            'document' => 'Domain\Files\Models\Document',
            'expense' => 'Domain\Expenses\Models\Expense',
            'expense-type' => 'Domain\Expenses\Models\ExpenseType',
            'holiday' => 'Domain\Absences\Models\Holiday',
            'notification' => 'Domain\Notifications\Models\Notification',
            'objective' => 'Domain\Performance\Models\Objective',
            'one-to-one' => 'Domain\Performance\Models\OneToOne',
            'organisation' => 'Domain\Organisation\Models\Organisation',
            'person' => 'Domain\People\Models\Person',
            'sickness' => 'Domain\Absences\Models\Sickness',
            'task' => 'Domain\Performance\Models\Task',
            'training' => 'Domain\Performance\Models\Training',
            'user' => 'Domain\Auth\Models\User',
            'vacancy' => 'Domain\Recruitment\Models\Vacancy'
        ]);

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }
}
