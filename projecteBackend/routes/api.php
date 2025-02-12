<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OperatorController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CallController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ZoneController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\AlertController;   
use App\Http\Controllers\Api\RelationshipController;

Route::post('login', [AuthController::class, 'login'])->middleware('api');
Route::post('register', [AuthController::class, 'register'])->middleware('api');
// Route::get('login/google', [AuthController::class, 'redirectToGoogle'])->middleware('api');
// Route::get('login/google/callback', [AuthController::class, 'handleGoogleCallback'])->middleware('api');
Route::middleware(['web'])->group(function () {
    Route::get('login/google', [AuthController::class, 'redirectToGoogle']);
    Route::get('login/google/callback', [AuthController::class, 'handleGoogleCallback']);
});


Route::middleware(['auth:sanctum','api'])->group( function () {    
    Route::apiResource('operators', OperatorController::class);
    Route::apiResource('patients', PatientController::class);
    Route::apiResource('calls', CallController::class);
    Route::apiResource('zones', ZoneController::class);
    Route::apiResource('languages', LanguageController::class);
    Route::apiResource('alerts', AlertController::class);

    Route::get('relationships', [RelationshipController::class, 'index']);
    

    Route::get('operators/{id}/calls', [OperatorController::class, 'getCallHistoryByOperator']);
    Route::get('patients/{id}/calls', [PatientController::class, 'getCallHistoryByPatient']);

    Route::get('reports/emergencies', [ReportController::class, 'getEmergencies']);
    Route::get('reports/socials', [ReportController::class, 'getSocials']);
    Route::get('reports/monitoring', [ReportController::class, 'getMonitorings']);

    // Route::get('alerts', [AlertController::class, 'index']);
    // Route::get('alerts/{alert}', [AlertController::class, 'show']);

    Route::post('logout', [AuthController::class, 'logout']);

});

// Route::get('reports/emergencies', [ReportController::class, 'getEmergencies']);
// Route::get('reports/socials', [ReportController::class, 'getSocials']);
// Route::get('reports/monitoring', [ReportController::class, 'getMonitorings']);