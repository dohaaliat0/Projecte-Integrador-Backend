<?php 
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\JugadoraController;
// use App\Http\Controllers\Api\AuthController;
// use App\Http\Controllers\Api\EquipController;
// use App\Http\Controllers\Api\EstadiController;
// use App\Http\Controllers\Api\PartitController;

// Route::post('login', [AuthController::class, 'login'])->middleware('api');
// Route::post('register', [AuthController::class, 'register'])->middleware('api');


// Route::middleware(['auth:sanctum','api'])->group( function () {    
//     Route::apiResource('jugadores',  JugadoraController::class);
//     Route::apiResource('estadis', EstadiController::class);
//     Route::apiResource('equips', EquipController::class);
//     Route::apiResource('partits', PartitController::class);

//     //custom
//     Route::get('/equips/{equip}/jugadores', [EquipController::class, 'getJugadores']);
//     Route::get('/equips/{equip}/jugadores/{jugadora}', [EquipController::class, 'getJugadora']);
//     Route::get('/equips/local/{equip}', [EquipController::class, 'getPartitsLocal']);
//     Route::get('/equips/visitant/{equip}', [EquipController::class, 'getPartitsVisitant']);

//     Route::get('/estadis/{estadi}/equips', [EstadiController::class, 'getEquips']);

//     Route::post('logout', [AuthController::class, 'logout']);

// });
