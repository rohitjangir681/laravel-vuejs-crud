<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/employee', [EmployeeController::class, 'index']);
Route::post('/employee', [EmployeeController::class, 'store']);
Route::get('/employee/{id}', [EmployeeController::class, 'show']);
Route::put('/employee/{id}', [EmployeeController::class, 'update']);
Route::delete('/employee/{id}', [EmployeeController::class, 'destroy']);
