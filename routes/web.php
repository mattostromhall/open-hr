<?php

use App\Http\Dashboard\Controllers\DashboardController;
use App\Http\Setup\Controllers\SetupController;
use App\Http\Setup\Controllers\StoreHRController;
use App\Http\Setup\Controllers\StoreOrganisationController;
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

Route::middleware(['auth', 'setup'])->group(function () {
    Route::get('/dashboard', DashboardController::class)
        ->name('dashboard');
});
Route::middleware('auth')->group(function () {
    Route::get('/setup', [SetupController::class, 'index'])
        ->name('setup');
    Route::post('/setup', [SetupController::class, 'store'])
        ->name('setup');
    Route::post('/setup/organisation', StoreOrganisationController::class)
        ->name('setup.organisation');
    Route::post('/setup/hr', StoreHRController::class)
        ->name('setup.hr');
});

require __DIR__. '/auth.php';
