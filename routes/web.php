<?php

use App\Http\Absences\Controllers\HolidayCalendarController;
use App\Http\Absences\Controllers\HolidayController;
use App\Http\Absences\Controllers\ReviewHolidayController;
use App\Http\Auth\Controllers\RoleController;
use App\Http\Auth\Controllers\UpdateActiveController;
use App\Http\Auth\Controllers\UpdateEmailController;
use App\Http\Auth\Controllers\UpdatePasswordController;
use App\Http\Dashboard\Controllers\DashboardController;
use App\Http\Files\Controllers\DirectoryController;
use App\Http\Files\Controllers\DocumentController;
use App\Http\Files\Controllers\DownloadDocumentController;
use App\Http\Notifications\Controllers\OrganisationNotificationController;
use App\Http\Notifications\Controllers\ReadNotificationController;
use App\Http\People\Controllers\AddressController;
use App\Http\People\Controllers\DirectReportController;
use App\Http\People\Controllers\PersonController;
use App\Http\People\Controllers\PersonProfileController;
use App\Http\Performance\Controllers\ObjectiveController;
use App\Http\Performance\Controllers\OneToOneController;
use App\Http\Performance\Controllers\OneToOneInviteController;
use App\Http\Performance\Controllers\PerformanceController;
use App\Http\Setup\Controllers\SetupController;
use App\Http\Setup\Controllers\SetupOrganisationController;
use App\Http\Setup\Controllers\SetupPersonController;
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

Route::middleware(['auth', 'setup'])->group(function () {
    Route::get('/dashboard', DashboardController::class)
        ->name('dashboard');
    Route::redirect('/', 'dashboard');

    Route::get('/setup', [SetupController::class, 'index'])
        ->name('setup.index');

    Route::get('/organisation/notifications', [OrganisationNotificationController::class, 'index'])
        ->name('organisation.notifications');
    Route::get('/organisation/notifications/create', [OrganisationNotificationController::class, 'create'])
        ->name('organisation.notifications.create');
    Route::post('/organisation/notifications', [OrganisationNotificationController::class, 'store'])
        ->name('organisation.notifications.store');

    Route::post('/notifications/{notification}/read', ReadNotificationController::class)
        ->name('notifications.read');

    Route::patch('/users/{user}/update-email', UpdateEmailController::class)
        ->name('user.update.email');
    Route::patch('/users/{user}/update-password', UpdatePasswordController::class)
        ->name('user.update.password');
    Route::patch('/users/{user}/update-active', UpdateActiveController::class)
        ->name('user.update.active');

    Route::post('/users/{user}/roles', RoleController::class);

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

    Route::post('/people/{person}/direct-reports', DirectReportController::class);

    Route::get('/people/{person}/profile', [PersonProfileController::class, 'edit'])
        ->name('person.profile');
    Route::patch('/people/{person}/profile', [PersonProfileController::class, 'update'])
        ->name('profile.update.personal');

    Route::post('/people/{person}/address', [AddressController::class, 'store'])
        ->name('address.store');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])
        ->name('address.update');

    Route::get('holidays', [HolidayController::class, 'index'])
        ->name('holiday.index');
    Route::post('holidays', [HolidayController::class, 'store'])
        ->name('holiday.store');
    Route::get('holidays/calendar', HolidayCalendarController::class)
        ->name('holiday.calendar');
    Route::get('holidays/{holiday}', [HolidayController::class, 'show'])
        ->name('holiday.show');
    Route::get('holidays/{holiday}/edit', [HolidayController::class, 'edit'])
        ->name('holiday.edit');
    Route::put('holidays/{holiday}', [HolidayController::class, 'update'])
        ->name('holiday.update');
    Route::get('holidays/{holiday}/review', [ReviewHolidayController::class, 'show'])
        ->name('holiday.review.show');
    Route::patch('holidays/{holiday}/review', [ReviewHolidayController::class, 'update'])
        ->name('holiday.review.update');

    Route::get('documents', [DocumentController::class, 'index'])
        ->name('document.index');
    Route::post('documents', [DocumentController::class, 'store'])
        ->name('document.store');
    Route::get('documents/download/{path}', DownloadDocumentController::class)
        ->where('path', '.*')
        ->name('document.download');
    Route::get('documents/{path}', [DocumentController::class, 'index'])
        ->where('path', '.*')
        ->name('document.index.path');

    Route::post('/directories', [DirectoryController::class, 'store'])
        ->name('directory.store');

    Route::get('/performance', PerformanceController::class)
        ->name('performance.index');

    Route::post('/one-to-ones', [OneToOneController::class, 'store'])
        ->name('one-to-one.store');
    Route::get('/one-to-ones/{one_to_one}', [OneToOneController::class, 'show'])
        ->name('one-to-one.show');
    Route::put('/one-to-ones/{one_to_one}', [OneToOneController::class, 'update'])
        ->name('one-to-one.update');
    Route::get('/one-to-ones/{one_to_one}/edit', [OneToOneController::class, 'edit'])
        ->name('one-to-one.edit');
    Route::get('/one-to-ones/{one_to_one}/invite', [OneToOneInviteController::class, 'show'])
        ->name('one-to-one.invite.show');
    Route::patch('/one-to-ones/{one_to_one}/invite', [OneToOneInviteController::class, 'update'])
        ->name('one-to-one.invite.update');

    Route::post('/objectives', [ObjectiveController::class, 'store'])
        ->name('objective.store');
    Route::put('/objectives/{objective}', [ObjectiveController::class, 'update'])
        ->name('objective.store');
    Route::get('/objectives/{objective}', [ObjectiveController::class, 'show'])
        ->name('objective.show');
    Route::get('/objectives/{objective}/edit', [ObjectiveController::class, 'edit'])
        ->name('objective.edit');
});

require __DIR__ . '/auth.php';
