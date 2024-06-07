<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/profile', [AuthController::class, 'profile']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::post('/post/create', [PostController::class, 'create']);
    Route::get('/post/all', [PostController::class, 'all']);
    Route::get('/post/{id}', [PostController::class, 'show']);
    Route::put('/post/edit/{id}', [PostController::class, 'edit']);
    Route::delete('/post/delete/{id}', [PostController::class, 'delete']);
});
