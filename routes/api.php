<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RiderController;
use App\Http\Controllers\SocketTestController;
use App\Http\Controllers\Api\CustomerController;
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
//,'middleware' => 'throttle:60,1'
//rider routes

    Route::group(['prefix' => 'v1'], function() {
        Route::post('firebase-testing', [CustomerController::class, 'testfirebase']);
    });
Route::post('/searchRider',[RiderController::class,'searchRider'])->name('searchRider');
Route::get('/v1/hello-socket-programming', [SocketTestController::class, 'testSocketEvent']);

Route::fallback(function () {
    return response()->json(['message' => ['Server was not able to retrieve the requested page.']], 404);
});
