<?php

use App\Http\Controllers\Backend\AddressController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductImageController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\HomeController;
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

Route::get('/', [HomeController::class, 'index']);
Route::get('/kategori/{category:slug}', [\App\Http\Controllers\Frontend\CategoryController::class, 'index']);

Route::get("/giris", [AuthController::class, 'signInForm']);
Route::post("/giris", [AuthController::class, 'signIn']);

Route::get("/uye-ol", [AuthController::class, 'signUpForm']);
Route::post("/uye-ol", [AuthController::class, 'signUp']);

Route::get("/cikis", [AuthController::class, 'logOut']);
Route::get("/hesabim", [\App\Http\Controllers\Frontend\UserController::class, 'index']);

Route::resource("/users", UserController::class);
Route::get("/users/{user}/change-password", [UserController::class, 'passwordForm']);
Route::post("/users/{user}/change-password", [UserController::class, 'changePassword']);
Route::resource("/users/{user}/addresses", AddressController::class);
Route::resource("/categories", CategoryController::class);
Route::resource("/products", ProductController::class);
Route::resource("/products/{product}/images", ProductImageController::class);
