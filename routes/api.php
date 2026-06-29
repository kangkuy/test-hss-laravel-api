<?php

use App\Http\Controllers\api\auth\LoginController;
use App\Http\Controllers\api\PromptingController;
use App\Http\Controllers\api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [LoginController::class, 'login']);
Route::post('prompt', [PromptingController::class, 'prompt'])->middleware('auth:sanctum');
Route::get('employee-data', [LoginController::class, 'employeeData']);

Route::group(['prefix' => 'task', 'middleware'=>'auth:sanctum'], function(){
    Route::get('/data', [TaskController::class, 'data']);
    Route::post('/store', [TaskController::class, 'store']);
    Route::delete('/delete/{id}', [TaskController::class, 'destroy']);
});