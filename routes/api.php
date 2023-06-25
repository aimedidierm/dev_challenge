<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [AuthController::class, 'mobileLogin']);
Route::post('/register', [AuthController::class, 'mobileRegister']);
Route::get('/profile', [UserController::class, 'edit']);
Route::put('/profile', [UserController::class, 'updateApi']);

Route::group(["prefix" => "project", "middleware" => ["auth:api", "projectManager"], "as" => "project."], function () {
    Route::post('/request', [PackageController::class, 'projectCreate']);
    Route::get('/all', [PackageController::class, 'listAll']);
    Route::get('/all/{id}', [PackageController::class, 'delete']);
});

Route::group(["prefix" => "finance", "middleware" => ["auth:api", "financeManager"], "as" => "finance."], function () {
    Route::get('/all', [PackageController::class, 'listAll']);
    Route::get('/all/reject/{id}', [PackageController::class, 'rejectApi']);
    Route::get('/all/approve/{id}', [PackageController::class, 'approveApi']);
});

Route::group(["prefix" => "general", "middleware" => ["auth:api", "generalManager"], "as" => "general."], function () {
    Route::get('/all', [PackageController::class, 'listAll']);
    Route::get('/all/reject/{id}', [PackageController::class, 'rejectApi']);
    Route::get('/all/approve/{id}', [PackageController::class, 'approveApi']);
});
