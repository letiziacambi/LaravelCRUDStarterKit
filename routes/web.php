<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CredentialController;
use App\Http\Controllers\TodoController;
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

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('/people', PeopleController::class);
Route::resource('/project', ProjectController::class);
Route::resource('/credential', CredentialController::class);
Route::resource('/todo', TodoController::class);

Route::prefix('api')->group(function () {
    Route::prefix('credential')->group(function () {
        Route::get('/', [CredentialController::class, 'records']);
        Route::get('info', [CredentialController::class, 'info']);
    });
    Route::prefix('todo')->group(function () {
        Route::get('/', [TodoController::class, 'records']);
        Route::get('info', [TodoController::class, 'info']);
    });
});
require __DIR__ . '/auth.php';
