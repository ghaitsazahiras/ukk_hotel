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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/room_type",[App\Http\Controllers\RoomTypeController::class, 'add']);
Route::put("/room_type/{id}",[App\Http\Controllers\RoomTypeController::class, 'update']);
Route::delete("/room_type/{id}",[App\Http\Controllers\RoomTypeController::class, 'destroy']);
Route::get("/room_type",[App\Http\Controllers\RoomTypeController::class, 'show']);
Route::get("/room_type/{id}",[App\Http\Controllers\RoomTypeController::class, 'detail']);

Route::post("/room",[App\Http\Controllers\RoomController::class, 'add']);
Route::put("/room/{id}",[App\Http\Controllers\RoomController::class, 'update']);
Route::delete("/room/{id}",[App\Http\Controllers\RoomController::class, 'destroy']);
Route::get("/room",[App\Http\Controllers\RoomController::class, 'show']);
Route::get("/room/{id}",[App\Http\Controllers\RoomController::class, 'detail']);