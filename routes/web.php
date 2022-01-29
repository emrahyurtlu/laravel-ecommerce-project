<?php

use App\Http\Controllers\Backend\AddressController;
use App\Http\Controllers\Backend\UserController;
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

Route::get('/', function () {
    return "Merhaba, burası anasayfa";
});

Route::resource("/users", UserController::class);
Route::get("/users/{user}/change-password", [UserController::class, 'passwordForm']);
Route::post("/users/{user}/change-password", [UserController::class, 'changePassword']);
Route::resource("/users/{user}/addresses", AddressController::class);
