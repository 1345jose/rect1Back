<?php

use App\Http\Modules\Auth\Controllers\AuthController;
use App\Http\Modules\Usuarios\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('crear-usuario', [AuthController::class, 'crearUsuario']);
    Route::post('loguear-usuario', [AuthController::class, 'loguearUsuario']);
});