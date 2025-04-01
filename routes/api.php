<?php

use App\Http\Middleware\FirebaseAuth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;

Route::prefix('tasks')->middleware(FirebaseAuth::class)->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::get('/{id}', [TaskController::class, 'show']);
    Route::post('/', [TaskController::class, 'store']);
    Route::put('/{id}', [TaskController::class, 'update']);
    Route::delete('/{id}', [TaskController::class, 'destroy']);
});
