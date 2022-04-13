<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PilotController;
use App\Http\Controllers\ShipController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResources([
    'pilots' => PilotController::class,
    'ships' => ShipController::class,
]);

Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('register', [AuthController::class, 'register'])->name('auth.register');
