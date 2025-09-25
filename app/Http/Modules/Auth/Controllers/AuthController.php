<?php

namespace App\Http\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Auth\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    public function crearUsuario(Request $request)
    {
        try {
            $usuario = $this->authService->crearUsuario($request->all());
            return response()->json($usuario, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Ha ocurrido un error al crear el usuario'
            ], 500);
        }
    }

    public function loguearUsuario(Request $request)
    {
        try {
            $loguear = $this->authService->loguearUsuario($request->all());
            return response()->json($loguear, 200);
        } catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
                'mensaje' => 'Ha ocurrido un error al crear el usuario'
            ], 500);
        }
    }
}
