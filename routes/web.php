<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Select2SearchController;
use App\Http\Controllers\Auth\VerificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/login')->middleware('guest');

Route::redirect('/','/home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth', 'middleware' => 'notverified', 'prefix' => 'email'], function() {
    Route::get('/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('/verification-notification', [VerificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.resend');
    Route::put('/changeEmail', [VerificationController::class, 'change'])->name('verification.change');
});

Route::group(['middleware'=>'auth', 'middleware' => 'verified'], function () {
    Route::get('/dashboard', [UserController::class, 'show'])->name('dashboard');

    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
    Route::put('/users/{user}/makeAdmin', [UserController::class, 'makeAdmin'])->middleware('admin')->name('users.makeAdmin');

    Route::get('/clients/search', [ClientController::class, 'search'])->name('clients.search');

    Route::get('/projects/search', [ProjectController::class, 'search'])->name('projects.search');
    Route::get('/projects/all', [ProjectController::class, 'allIndex'])->name('projects.all');
    Route::get('/projects/complete', [ProjectController::class, 'completeIndex'])->name('projects.complete');

    Route::get('/tasks/search', [TaskController::class, 'search'])->name('tasks.search');
    Route::get('/tasks/complete', [TaskController::class, 'completeIndex'])->name('tasks.complete');
    Route::put('/tasks/{task}/markComplete', [TaskController::class, 'markComplete'])->name('tasks.markComplete');

    Route::resource('users', UserController::class)->only(['show','index', 'edit', 'update']);
    Route::resource('clients', ClientController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('tasks', TaskController::class);
});