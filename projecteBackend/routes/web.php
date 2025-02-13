<?php

use App\Http\Controllers\AltaYBajaController;
use App\Http\Controllers\AsignUsersController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Enums\UserRole;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', RoleMiddleware::class.':'.UserRole::COORDINATOR->value])->group(function () {
    Route::resource('webzones', ZoneController::class)
        ->parameters(['webzones' => 'zone']);
    Route::resource('assignusers', AsignUsersController::class)
        ->parameters( ['assignusers' => 'patient']);
    Route::resource('altabaja', AltaYBajaController::class)
        ->parameters(['altabaja' => 'users'])
        ->except(['show', 'update']);
    Route::get('altabaja/altaAntiguo', [AltaYBajaController::class, 'altaAntiguoUser'])
        ->name('altabaja.altaAntiguoUser');
    Route::put('altabaja/updateAltaAntiguoUser', [AltaYBajaController::class, 'updateAltaAntiguoUser'])
        ->name('altabaja.updateAltaAntiguoUser');
});

require __DIR__.'/auth.php';
