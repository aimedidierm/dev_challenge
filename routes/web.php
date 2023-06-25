<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'login')->name('login');
Route::view('/register', 'register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [UserController::class, 'store']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::group(["prefix" => "project", "middleware" => ["auth", "projectManager"], "as" => "project."], function () {
    Route::view('/', 'project.request');
    Route::get('/settings', [UserController::class, 'create']);
    Route::put('/settings', [UserController::class, 'update']);
    Route::resource('/all', PackageController::class)->only('index', 'store', 'destroy');
});

Route::group(["prefix" => "finance", "middleware" => ["auth", "financeManager"], "as" => "finance."], function () {
    Route::get('/', [PackageController::class, 'financeList']);
    Route::get('/settings', [UserController::class, 'create']);
    Route::put('/settings', [UserController::class, 'update']);
    Route::get('/approve/{id}', [PackageController::class, 'financeApprove']);
    Route::get('/reject/{id}', [PackageController::class, 'reject']);
});

Route::group(["prefix" => "general", "middleware" => ["auth", "generalManager"], "as" => "general."], function () {
    Route::get('/', [PackageController::class, 'generalList']);
    Route::get('/approve/{id}', [PackageController::class, 'generalApprove']);
    Route::get('/reject/{id}', [PackageController::class, 'reject']);
    Route::get('/settings', [UserController::class, 'create']);
    Route::put('/settings', [UserController::class, 'update']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/approve/{id}', [UserController::class, 'approvedUser']);
    Route::get('/user/reject/{id}', [UserController::class, 'destroy']);
});
