<?php

use App\Http\Modules\Usuarios\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::prefix('usuarios')->group(function () {
    Route::controller(UsuarioController::class)->group(function () {
        Route::post('crear', 'crearUsuario');
    });
});