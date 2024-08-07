<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/health-check', function () {
    return response()->json(['status' => 'ok']);
});


Route::prefix('tasks')->group(function () {
    Route::get('/', [\App\Http\Controllers\TaskController::class, 'getAll']);
    Route::get('/{id}', [\App\Http\Controllers\TaskController::class, 'get']);
    Route::post('/', [\App\Http\Controllers\TaskController::class, 'create']);
    Route::put('/{id}', [\App\Http\Controllers\TaskController::class, 'update']);
    Route::delete('/{id}', [\App\Http\Controllers\TaskController::class, 'delete']);
});
