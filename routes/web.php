<?php

use App\Http\Absences\Controllers\HolidayController;
use App\Http\Absences\Controllers\ReviewHolidayController;
use App\Http\Auth\Controllers\UpdateEmailController;
use App\Http\Auth\Controllers\UpdatePasswordController;
use App\Http\Dashboard\Controllers\DashboardController;
use App\Http\Notifications\Controllers\ReadNotificationController;
use App\Http\People\Controllers\AddressController;
use App\Http\People\Controllers\PersonProfileController;
use App\Http\Setup\Controllers\SetupController;
use App\Http\Setup\Controllers\SetupOrganisationController;
use App\Http\Setup\Controllers\SetupPersonController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

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
    Route::get('/setup', [SetupController::class, 'index'])
        ->name('setup.index');

    Route::post('/notifications/{notification}/read', ReadNotificationController::class)
        ->name('notifications.read');

    Route::get('/people/{person}/profile', [PersonProfileController::class, 'edit'])
        ->name('person.profile');
    Route::patch('/people/{person}/profile', [PersonProfileController::class, 'update'])
        ->name('profile.update.personal');

    Route::patch('/profile/update-email', UpdateEmailController::class)
        ->name('profile.update.email');
    Route::patch('/profile/update-password', UpdatePasswordController::class)
        ->name('profile.update.password');

    Route::post('/people/{person}/address', [AddressController::class, 'store'])
        ->name('address.store');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])
        ->name('address.update');

    Route::get('holidays', [HolidayController::class, 'index'])
        ->name('holiday.index');
    Route::post('holidays', [HolidayController::class, 'store'])
        ->name('holiday.store');
    Route::get('holidays/{holiday}/review', ReviewHolidayController::class)
        ->name('holiday.review');
});

require __DIR__. '/auth.php';
