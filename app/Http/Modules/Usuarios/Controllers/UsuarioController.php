<?php

namespace App\Http\Modules\Usuarios\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Usuarios\Services\UsuarioService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsuarioController extends Controller
{
    public function __construct(protected UsuarioService $usuarioService)
    {
    }
    public function crearUsuario(Request $request): JsonResponse
    {
        try {
            $usuario = $this->usuarioService->crear($request->all());
            return response()->json($usuario, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Ha ocurrido un error al crear el usuario'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
}
