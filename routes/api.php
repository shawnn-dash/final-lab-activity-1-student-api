<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StudentController;

// PUBLIC LOGIN
Route::post('/login', [AuthController::class, 'login']);

// AUTHENTICATED USERS
Route::middleware('auth:sanctum')->group(function () {

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout']);

    // ADMIN AND REGULAR USER CAN READ
    Route::get('/students', [StudentController::class, 'index']);
    Route::get('/students/{student}', [StudentController::class, 'show']);

    // ADMINISTRATOR ONLY
    Route::middleware('admin')->group(function () {

        Route::post('/students', [StudentController::class, 'store']);

        Route::put('/students/{student}', [StudentController::class, 'update']);

        Route::patch('/students/{student}', [StudentController::class, 'update']);

        Route::delete('/students/{student}', [StudentController::class, 'destroy']);

    });

});

//Route::apiResource('students', StudentController::class);

