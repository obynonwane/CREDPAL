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



//Question2
//auth endpoints
Route::group(["middleware" => "jwt"], function () {
    Route::post("logout", "AuthController@logout");
    Route::post("addcurrency", "BaseCurrencyController@setBaseCurreency");
    Route::get("rates", "BaseCurrencyController@rates");
    Route::post("threshold", "ThresholdController@setThreshold");
});
Route::post("register", "AuthController@register");
Route::post("login", "AuthController@login");

//question1 Routes
Route::post("loan", "CustomerLoanController@calculateloan");
