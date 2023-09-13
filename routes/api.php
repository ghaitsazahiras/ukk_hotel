<?php

use Illuminate\Http\Request;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\ReceptionistAuth;
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

Route::post('/register', [App\Http\Controllers\UserController::class, 'register']);
Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);

Route::get("/room_type",[App\Http\Controllers\RoomTypeController::class, 'show']);
Route::get("/room_type/{id}",[App\Http\Controllers\RoomTypeController::class, 'detail']);
Route::get("/room",[App\Http\Controllers\RoomController::class, 'show']);
Route::get("/room/{id}",[App\Http\Controllers\RoomController::class, 'detail']);
Route::get("/order_detail/{id}",[App\Http\Controllers\OrderDetailController::class, 'detail']);

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::group(['middleware' => ['api.admin']], function ()
    {
        Route::post("/room_type",[App\Http\Controllers\RoomTypeController::class, 'add']);
        Route::put("/room_type/{id}",[App\Http\Controllers\RoomTypeController::class, 'update']);
        Route::delete("/room_type/{id}",[App\Http\Controllers\RoomTypeController::class, 'destroy']);
    
        Route::post("/room",[App\Http\Controllers\RoomController::class, 'add']);
        Route::put("/room/{id}",[App\Http\Controllers\RoomController::class, 'update']);
        Route::delete("/room/{id}",[App\Http\Controllers\RoomController::class, 'destroy']);
    });
    
    Route::group(['middleware' => ['api.receptionist']], function ()
    {
        Route::post("/order",[App\Http\Controllers\OrderController::class, 'add']);
        Route::get("/order",[App\Http\Controllers\OrderController::class, 'show']);
        Route::get("/order/{id}",[App\Http\Controllers\OrderController::class, 'detail']);
        Route::put("/order/{id}",[App\Http\Controllers\OrderController::class, 'update']);
        Route::delete("/order/{id}",[App\Http\Controllers\OrderController::class, 'destroy']);
    
        Route::post("/order_detail",[App\Http\Controllers\OrderDetailController::class, 'add']);
        Route::put("/order_detail/{id}",[App\Http\Controllers\OrderDetailController::class, 'update']);
        Route::get("/order_detail",[App\Http\Controllers\OrderDetailController::class, 'show']);
        Route::delete("/order_detail/{id}",[App\Http\Controllers\OrderDetailController::class, 'destroy']);

        Route::get("/order/filter/date/{date}",[App\Http\Controllers\OrderController::class, 'filterByCheckIn']);
        Route::get("/order/filter/name/{name}",[App\Http\Controllers\OrderController::class, 'filterByName']);
    });
});