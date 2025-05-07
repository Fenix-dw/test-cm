<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:sanctum'],function (){
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('news.comments', CommentController::class)->shallow();

});

Route::post('login', [AuthController::class, 'login']);
