<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\API\ProductAPIController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('product', ProductAPIController::class);

Route::delete('product', [App\Http\Controllers\API\ProductAPIController::class,'destroyMassive']);

Route::patch('product', [App\Http\Controllers\API\ProductAPIController::class,'updateMassive']);

Route::resource('productLogs', ProductLogAPIController::class);
