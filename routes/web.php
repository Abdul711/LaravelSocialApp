<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontEndController;
use Illuminate\Support\Facades\Route;
Route::middleware(['auth'])->group(function () {
Route::get('/',[FrontEndController::class,"index"]);
});
Route::get("login",[AuthController::class,"login"])->name("login");
Route::get("signup",[AuthController::class,"signup"]);
Route::post("signup",[AuthController::class,"register"]);
Route::post("login",[AuthController::class,"logined"]);
Route::get('signout',[AuthController::class,"logout"]);
