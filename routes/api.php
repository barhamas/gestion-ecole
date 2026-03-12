<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\EtudiantController;
use App\Http\Controllers\Api\V1\CoursController;
use Illuminate\Support\Facades\Route;

// Auth publiques
Route::prefix('v1/auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me',      [AuthController::class, 'me']);
    });
});

// Routes protégées avec notre middleware custom
Route::prefix('v1')
    ->middleware(['App\Http\Middleware\ApiAuthenticate:sanctum', 'throttle:60,1'])
    ->group(function () {
        Route::apiResource('etudiants', EtudiantController::class);
        Route::post('etudiants/{etudiant}/cours/attach', [EtudiantController::class, 'attachCours']);
        Route::post('etudiants/{etudiant}/cours/detach', [EtudiantController::class, 'detachCours']);
        Route::post('etudiants/{etudiant}/cours/sync',   [EtudiantController::class, 'syncCours']);
        Route::apiResource('cours', CoursController::class);
    });
