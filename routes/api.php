<?php

use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('tasks', TaskController::class);
    Route::get('tasks/complete/{task}', [TaskController::class, 'completeTask']);

    Route::post('logout',[AuthController::class,'logout']);
    Route::get('me',[AuthController::class,'me']);
});

Route::post('login',[AuthController::class,'login']);
Route::post('register',[AuthController::class,'register']);
