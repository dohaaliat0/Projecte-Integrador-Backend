<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OperatorController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CallController;
use App\Http\Controllers\Api\ReportController;

Route::post('login', [AuthController::class, 'login'])->middleware('api');
Route::post('register', [AuthController::class, 'register'])->middleware('api');


Route::middleware(['auth:sanctum','api'])->group( function () {    
    Route::apiResource('operators', OperatorController::class);
    Route::apiResource('patients', PatientController::class);
    Route::apiResource('calls', CallController::class);

    Route::get('operators/{id}/calls', [OperatorController::class, 'getCallHistoryByOperator']);
    Route::get('patients/{id}/calls', [PatientController::class, 'getCallHistoryByPatient']);

    Route::get('reports/emergencies', [ReportController::class, 'getEmergencies']);
    Route::get('reports/socials', [ReportController::class, 'getSocials']);
    // Route::get('reports/monitoring', [ReportController::class, 'getMonitorings']);

    Route::post('logout', [AuthController::class, 'logout']);

});
// test route without middleware
Route::get('reports/monitoring', [ReportController::class, 'getMonitorings']);
