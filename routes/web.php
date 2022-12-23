<?php

use App\Http\Absences\Controllers\HolidayCalendarController;
use App\Http\Absences\Controllers\HolidayController;
use App\Http\Absences\Controllers\ReviewHolidayController;
use App\Http\Absences\Controllers\SicknessController;
use App\Http\Auth\Controllers\RoleController;
use App\Http\Auth\Controllers\UpdateActiveController;
use App\Http\Auth\Controllers\UpdateEmailController;
use App\Http\Auth\Controllers\UpdatePasswordController;
use App\Http\Dashboard\Controllers\DashboardController;
use App\Http\Dashboard\Controllers\DepartmentDashboardController;
use App\Http\Dashboard\Controllers\ManagementDashboardController;
use App\Http\Dashboard\Controllers\OrganisationDashboardController;
use App\Http\Departments\Controllers\DepartmentController;
use App\Http\Departments\Controllers\DepartmentMemberController;
use App\Http\Expenses\Controllers\ExpenseController;
use App\Http\Expenses\Controllers\ExpenseTypeController;
use App\Http\Expenses\Controllers\ReviewExpenseController;
use App\Http\Files\Controllers\DirectoryController;
use App\Http\Files\Controllers\DocumentController;
use App\Http\Files\Controllers\DownloadDocumentController;
use App\Http\Notifications\Controllers\NotificationController;
use App\Http\Notifications\Controllers\OrganisationNotificationController;
use App\Http\Notifications\Controllers\ReadNotificationController;
use App\Http\People\Controllers\AddressController;
use App\Http\People\Controllers\DirectReportController;
use App\Http\People\Controllers\PersonController;
use App\Http\People\Controllers\PersonProfileController;
use App\Http\Performance\Controllers\CompleteObjectiveController;
use App\Http\Performance\Controllers\CompleteOneToOneController;
use App\Http\Performance\Controllers\CompleteTaskController;
use App\Http\Performance\Controllers\CompleteTrainingController;
use App\Http\Performance\Controllers\ObjectiveController;
use App\Http\Performance\Controllers\ObjectiveTaskController;
use App\Http\Performance\Controllers\OneToOneController;
use App\Http\Performance\Controllers\OneToOneInviteController;
use App\Http\Performance\Controllers\PerformanceController;
use App\Http\Performance\Controllers\ReviewTrainingController;
use App\Http\Performance\Controllers\StartTrainingController;
use App\Http\Performance\Controllers\TrainingController;
use App\Http\Recruitment\Controllers\ApplicationController;
use App\Http\Recruitment\Controllers\ApplicationThanksController;
use App\Http\Recruitment\Controllers\PendingApplicationController;
use App\Http\Recruitment\Controllers\SuccessfulApplicationController;
use App\Http\Recruitment\Controllers\UnsuccessfulApplicationController;
use App\Http\Recruitment\Controllers\VacancyApplicationController;
use App\Http\Recruitment\Controllers\VacancyController;
use App\Http\Reports\Controllers\GenerateReportController;
use App\Http\Reports\Controllers\RelationshipOptionsController;
use App\Http\Setup\Controllers\SetupController;
use App\Http\Setup\Controllers\SetupOrganisationController;
use App\Http\Setup\Controllers\SetupPersonController;
use App\Http\Support\Controllers\ActionLogController;
use App\Http\Reports\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::post('/setup', [SetupController::class, 'store'])
        ->name('setup.store');
    Route::post('/setup/organisation', SetupOrganisationController::class)
        ->name('setup.organisation');
    Route::post('/setup/person', SetupPersonController::class)
        ->name('setup.person');
});

Route::middleware(['setup'])->group(function () {
    Route::get('/vacancies/{vacancy:public_id}/apply', VacancyApplicationController::class)
        ->name('vacancy.application');

    Route::get('/applications/thanks', ApplicationThanksController::class)
        ->name('application.thanks');

    Route::post('/applications', [ApplicationController::class, 'store'])
        ->name('application.store');
});

Route::middleware(['auth', 'active', 'setup'])->group(function () {
    Route::get('/dashboard', DashboardController::class)
        ->name('dashboard');
    Route::get('/dashboard/management', ManagementDashboardController::class)
        ->name('dashboard.management');
    Route::get('/dashboard/department', DepartmentDashboardController::class)
        ->name('dashboard.department');
    Route::get('/dashboard/organisation', OrganisationDashboardController::class)
        ->name('dashboard.organisation');
    Route::redirect('/', 'dashboard');

    Route::get('/setup', [SetupController::class, 'index'])
        ->name('setup.index');

    Route::get('/organisation/notifications', [OrganisationNotificationController::class, 'index'])
        ->name('organisation.notifications');
    Route::get('/organisation/notifications/create', [OrganisationNotificationController::class, 'create'])
        ->name('organisation.notification.create');
    Route::post('/organisation/notifications', [OrganisationNotificationController::class, 'store'])
        ->name('organisation.notification.store');

    Route::post('/notifications/{notification}/read', ReadNotificationController::class)
        ->name('notifications.read');

    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])
        ->name('notifications.destroy');

    Route::patch('/users/{user}/update-email', UpdateEmailController::class)
        ->name('user.update.email');
    Route::patch('/users/{user}/update-password', UpdatePasswordController::class)
        ->name('user.update.password');
    Route::patch('/users/{user}/update-active', UpdateActiveController::class)
        ->name('user.update.active');

    Route::post('/users/{user}/roles', RoleController::class)
        ->name('roles/sync');

    Route::get('/people', [PersonController::class, 'index'])
        ->name('person.index');
    Route::get('/people/create', [PersonController::class, 'create'])
        ->name('person.create');
    Route::post('/people', [PersonController::class, 'store'])
        ->name('person.store');
    Route::get('/people/{person}', [PersonController::class, 'show'])
        ->name('person.show');
    Route::get('/people/{person}/edit', [PersonController::class, 'edit'])
        ->name('person.edit');
    Route::put('/people/{person}', [PersonController::class, 'update'])
        ->name('person.update');
    Route::delete('/people/{person}', [PersonController::class, 'destroy'])
        ->name('person.destroy');

    Route::post('/people/{person}/direct-reports', DirectReportController::class)
        ->name('person.direct-reports');

    Route::get('/people/{person}/profile', [PersonProfileController::class, 'edit'])
        ->name('person.profile');
    Route::patch('/people/{person}/profile', [PersonProfileController::class, 'update'])
        ->name('profile.update');

    Route::post('/people/{person}/address', [AddressController::class, 'store'])
        ->name('address.store');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])
        ->name('address.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])
        ->name('address.destroy');

    Route::get('/holidays', [HolidayController::class, 'index'])
        ->name('holiday.index');
    Route::post('/holidays', [HolidayController::class, 'store'])
        ->name('holiday.store');
    Route::get('/holidays/calendar', HolidayCalendarController::class)
        ->name('holiday.calendar');
    Route::get('/holidays/{holiday}', [HolidayController::class, 'show'])
        ->name('holiday.show');
    Route::get('/holidays/{holiday}/edit', [HolidayController::class, 'edit'])
        ->name('holiday.edit');
    Route::put('/holidays/{holiday}', [HolidayController::class, 'update'])
        ->name('holiday.update');
    Route::delete('/holidays/{holiday}', [HolidayController::class, 'destroy'])
        ->name('holiday.destroy');
    Route::get('/holidays/{holiday}/review', [ReviewHolidayController::class, 'show'])
        ->name('holiday.review.show');
    Route::patch('/holidays/{holiday}/review', [ReviewHolidayController::class, 'update'])
        ->name('holiday.review.update');

    Route::get('/sicknesses', [SicknessController::class, 'index'])
        ->name('sickness.index');
    Route::post('/sicknesses', [SicknessController::class, 'store'])
        ->name('sickness.store');
    Route::get('/sicknesses/{sickness}', [SicknessController::class, 'show'])
        ->name('sickness.show');
    Route::get('/sicknesses/{sickness}/edit', [SicknessController::class, 'edit'])
        ->name('sickness.edit');
    Route::put('/sicknesses/{sickness}', [SicknessController::class, 'update'])
        ->name('sickness.update');
    Route::delete('/sicknesses/{sickness}', [SicknessController::class, 'destroy'])
        ->name('sickness.destroy');

    Route::get('/documents', [DocumentController::class, 'index'])
        ->name('document.index');
    Route::post('/documents', [DocumentController::class, 'store'])
        ->name('document.store');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])
        ->name('document.destroy');
    Route::get('/documents/download/{path}', DownloadDocumentController::class)
        ->where('path', '.*')
        ->name('document.download');
    Route::get('/documents/{path}', [DocumentController::class, 'index'])
        ->where('path', '.*')
        ->name('document.index.path');

    Route::post('/directories', [DirectoryController::class, 'store'])
        ->name('directory.store');
    Route::post('/directories/delete', [DirectoryController::class, 'destroy'])
        ->name('directory.destroy');

    Route::get('/performance', PerformanceController::class)
        ->name('performance.index');

    Route::post('/one-to-ones', [OneToOneController::class, 'store'])
        ->name('one-to-one.store');
    Route::get('/one-to-ones/{one_to_one}', [OneToOneController::class, 'show'])
        ->name('one-to-one.show');
    Route::put('/one-to-ones/{one_to_one}', [OneToOneController::class, 'update'])
        ->name('one-to-one.update');
    Route::delete('/one-to-ones/{one_to_one}', [OneToOneController::class, 'destroy'])
        ->name('one-to-one.destroy');
    Route::get('/one-to-ones/{one_to_one}/edit', [OneToOneController::class, 'edit'])
        ->name('one-to-one.edit');
    Route::get('/one-to-ones/{one_to_one}/invite', [OneToOneInviteController::class, 'show'])
        ->name('one-to-one.invite.show');
    Route::patch('/one-to-ones/{one_to_one}/invite', [OneToOneInviteController::class, 'update'])
        ->name('one-to-one.invite.update');
    Route::post('/one-to-ones/{one_to_one}/complete', CompleteOneToOneController::class)
        ->name('one-to-one.complete');

    Route::post('/objectives', [ObjectiveController::class, 'store'])
        ->name('objective.store');
    Route::put('/objectives/{objective}', [ObjectiveController::class, 'update'])
        ->name('objective.update');
    Route::get('/objectives/{objective}', [ObjectiveController::class, 'show'])
        ->name('objective.show');
    Route::get('/objectives/{objective}/edit', [ObjectiveController::class, 'edit'])
        ->name('objective.edit');
    Route::delete('/objectives/{objective}', [ObjectiveController::class, 'destroy'])
        ->name('objective.destroy');
    Route::post('/objectives/{objective}/complete', CompleteObjectiveController::class)
        ->name('objective.complete');

    Route::post('/objectives/{objective}/tasks', [ObjectiveTaskController::class, 'store'])
        ->name('task.store');
    Route::put('/tasks/{task}', [ObjectiveTaskController::class, 'update'])
        ->name('task.update');
    Route::delete('/tasks/{task}', [ObjectiveTaskController::class, 'destroy'])
        ->name('task.destroy');
    Route::post('/tasks/{task}/complete', CompleteTaskController::class)
        ->name('task.complete');

    Route::get('/training', [TrainingController::class, 'index'])
        ->name('training.index');
    Route::post('/training', [TrainingController::class, 'store'])
        ->name('training.store');
    Route::get('/training/{training}', [TrainingController::class, 'show'])
        ->name('training.show');
    Route::get('/training/{training}/edit', [TrainingController::class, 'edit'])
        ->name('training.edit');
    Route::put('/training/{training}', [TrainingController::class, 'update'])
        ->name('training.update');
    Route::delete('/training/{training}', [TrainingController::class, 'destroy'])
        ->name('training.destroy');
    Route::post('/training/{training}/start', StartTrainingController::class)
        ->name('training.start');
    Route::post('/training/{training}/complete', CompleteTrainingController::class)
        ->name('training.complete');

    Route::get('/training/{training}/review', [ReviewTrainingController::class, 'show'])
        ->name('training.review.show');
    Route::patch('/training/{training}/review', [ReviewTrainingController::class, 'update'])
        ->name('training.review.update');

    Route::get('/departments', [DepartmentController::class, 'index'])
        ->name('department.index');
    Route::get('/departments/create', [DepartmentController::class, 'create'])
        ->name('department.create');
    Route::post('/departments', [DepartmentController::class, 'store'])
        ->name('department.store');
    Route::get('/departments/{department}', [DepartmentController::class, 'show'])
        ->name('department.show');
    Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])
        ->name('department.edit');
    Route::put('/departments/{department}', [DepartmentController::class, 'update'])
        ->name('department.update');
    Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])
        ->name('department.destroy');

    Route::post('/departments/{department}/members', DepartmentMemberController::class)
        ->name('department.members');

    Route::get('/expense-types', [ExpenseTypeController::class, 'index'])
        ->name('expense-type.index');
    Route::get('/expense-types/create', [ExpenseTypeController::class, 'create'])
        ->name('expense-type.create');
    Route::post('/expense-types', [ExpenseTypeController::class, 'store'])
        ->name('expense-type.store');
    Route::get('/expense-types/{expense_type}/edit', [ExpenseTypeController::class, 'edit'])
        ->name('expense-type.edit');
    Route::put('/expense-types/{expense_type}', [ExpenseTypeController::class, 'update'])
        ->name('expense-type.update');
    Route::delete('/expense-types/{expense_type}', [ExpenseTypeController::class, 'destroy'])
        ->name('expense-type.destroy');

    Route::get('/expenses', [ExpenseController::class, 'index'])
        ->name('expense.index');
    Route::post('/expenses', [ExpenseController::class, 'store'])
        ->name('expense.store');
    Route::get('/expenses/{expense}', [ExpenseController::class, 'show'])
        ->name('expense.show');
    Route::get('/expenses/{expense}/edit', [ExpenseController::class, 'edit'])
        ->name('expense.edit');
    Route::put('/expenses/{expense}', [ExpenseController::class, 'update'])
        ->name('expense.update');
    Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])
        ->name('expense.destroy');
    Route::get('/expenses/{expense}/review', [ReviewExpenseController::class, 'show'])
        ->name('expense.review.show');
    Route::patch('/expenses/{expense}/review', [ReviewExpenseController::class, 'update'])
        ->name('expense.review.update');

    Route::get('/vacancies', [VacancyController::class, 'index'])
        ->name('vacancy.index');
    Route::post('/vacancies', [VacancyController::class, 'store'])
        ->name('vacancy.store');
    Route::get('/vacancies/{vacancy}', [VacancyController::class, 'show'])
        ->name('vacancy.show');
    Route::get('/vacancies/{vacancy}/edit', [VacancyController::class, 'edit'])
        ->name('vacancy.edit');
    Route::put('/vacancies/{vacancy}', [VacancyController::class, 'update'])
        ->name('vacancy.update');
    Route::delete('/vacancies/{vacancy}', [VacancyController::class, 'destroy'])
        ->name('vacancy.destroy');

    Route::get('/applications/{application}', [ApplicationController::class, 'show'])
        ->name('application.show');
    Route::delete('/applications/{application}', [ApplicationController::class, 'destroy'])
        ->name('application.destroy');
    Route::post('/applications/{application}/pending', PendingApplicationController::class)
        ->name('application.pending');
    Route::post('/applications/{application}/successful', SuccessfulApplicationController::class)
        ->name('application.successful');
    Route::post('/applications/{application}/unsuccessful', UnsuccessfulApplicationController::class)
        ->name('application.unsuccessful');

    Route::get('/logs', [ActionLogController::class, 'index'])
        ->name('logs.index');
    Route::get('/logs/{type}/{id}', [ActionLogController::class, 'show'])
        ->name('logs.show');

    Route::get('/reports', [ReportController::class, 'index'])
        ->name('report.index');
    Route::get('/reports/create', [ReportController::class, 'create'])
        ->name('report.create');
    Route::post('/reports', [ReportController::class, 'store'])
        ->name('report.store');
    Route::get('/reports/{report}/edit', [ReportController::class, 'edit'])
        ->name('report.edit');
    Route::put('/reports/{report}', [ReportController::class, 'update'])
        ->name('report.update');
    Route::delete('/reports/{report}', [ReportController::class, 'destroy'])
        ->name('report.destroy');

    Route::post('/reports/generate', [GenerateReportController::class, 'store'])
        ->name('report.generate.store');
    Route::get('/reports/download/{path}', [GenerateReportController::class, 'show'])
        ->where('path', '.*')
        ->name('report.generate.show');

    Route::get('/relationship-options/{model}', RelationshipOptionsController::class)
        ->name('relationship.options');
});

require __DIR__ . '/auth.php';
