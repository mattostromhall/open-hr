<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Open HR Configuration
    |--------------------------------------------------------------------------
    */

    'absence_year_start' => 'January',
    'financial_year_start' => 'January',
    'sys_admin' => env('SYS_ADMIN', ''),

    /*
    |--------------------------------------------------------------------------
    | Reportable Models
    |--------------------------------------------------------------------------
    |
    | These are the models in the system than can be used to generate a report.
    |
    */

    'reportable' => [
        'address' => 'Domain\People\Models\Address',
        'application' => 'Domain\Recruitment\Models\Application',
        'department' => 'Domain\Organisation\Models\Department',
        'document' => 'Domain\Files\Models\Document',
        'expense' => 'Domain\Expenses\Models\Expense',
        'expense-type' => 'Domain\Expenses\Models\ExpenseType',
        'holiday' => 'Domain\Absences\Models\Holiday',
        'objective' => 'Domain\Performance\Models\Objective',
        'one-to-one' => 'Domain\Performance\Models\OneToOne',
        'person' => 'Domain\People\Models\Person',
        'sickness' => 'Domain\Absences\Models\Sickness',
        'task' => 'Domain\Performance\Models\Task',
        'training' => 'Domain\Performance\Models\Training',
        'user' => 'Domain\Auth\Models\User',
        'vacancy' => 'Domain\Recruitment\Models\Vacancy'
    ]
];
