<?php

use App\Http\Auth\Controllers\UpdateEmailController;
use App\Http\Dashboard\Controllers\DashboardController;
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

    Route::get('/people/{person}/profile', PersonProfileController::class)
        ->name('person.profile');

    Route::patch('/profile/update-email', UpdateEmailController::class)
        ->name('profile.update-email');
    Route::patch('/profile/update-password', UpdateEmailController::class)
        ->name('profile.update-password');
});

require __DIR__. '/auth.php';
