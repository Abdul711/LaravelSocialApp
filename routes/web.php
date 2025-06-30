<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get("login",[AuthController::class,"login"]);
Route::get("signup",[AuthController::class,"signup"]);
Route::post("signup",[AuthController::class,"register"]);
Route::post("login",[AuthController::class,"logined"]);