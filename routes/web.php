<?php

use App\Http\Controllers\User\AuthController;
use App\Http\Middleware\LoginMiddleware;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

/**
 * 
 * Main Routes
 * 
 */
Route::post('register' , [AuthController::class , "register"]);
Route::post('login' , [AuthController::class , "login"]);
/**
 * 
 * User Routes
 * 
 */
Route::middleware([LoginMiddleware::class])->group(function () {
    Route::get('main' , function(){
        return view('user.index');
    });

    Route::get('checkout' , function(){
        return view('user.checkout');
    });
});


