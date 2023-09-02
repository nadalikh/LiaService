<?php

use Illuminate\Http\Request;
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

//All user route
Route::resource("user", \App\Http\Controllers\UserController::class)
    ->missing('\App\Services\MySweetAbility::missingResponse');

//All product route
Route::resource("product", \App\Http\Controllers\ProductController::class)
    ->missing('\App\Services\MySweetAbility::missingResponse');

//All orders route
Route::resource("order", \App\Http\Controllers\OrderController::class)
    ->missing('\App\Services\MySweetAbility::missingResponse');
Route::group(['prefix' => "auth", "controller" => \App\Http\Controllers\AuthController::class], function(){
    Route::post("login", "login");
});
