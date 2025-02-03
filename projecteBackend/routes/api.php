<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OperatorController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CallController;

Route::post('login', [AuthController::class, 'login'])->middleware('api');
Route::post('register', [AuthController::class, 'register'])->middleware('api');


Route::middleware(['auth:sanctum','api'])->group( function () {    
    Route::apiResource('operators', OperatorController::class);
    Route::apiResource('patients', PatientController::class);
    Route::apiResource('calls', CallController::class);

    Route::post('logout', [AuthController::class, 'logout']);

});
