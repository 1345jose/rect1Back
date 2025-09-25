<?php

namespace App\Http\Modules\Auth\Services;

use App\Http\Modules\LoginSession\Models\LoginSession;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Error;


class AuthService
{
    public function crearUsuario(array $data)
    {
        if (User::where('email', $data['email'])->exists()) {
            throw new \Exception('Ya existe un usuario con ese Correo Electrónico', 409);
        }

        $usuario = User::create([
            'password' => bcrypt($data['password']),
            'email' => $data['email'],
            'nombre_completo' => $data['nombre_completo'],
            'documento' => $data['numero_documento'],
            'telefono' => $data['telefono'],
            'apellidos' => $data['apellidos'],
        ]);

        return [
            'id' => $usuario->id,
            'mensaje' => 'El usuario ha sido creado exitosamente',
        ];

    }

    public function loguearUsuario(array $data)
    {

        $email = $data['email'];
        $contrasena = $data['password'];

        if (
            !Auth::guard('web')->attempt([
                'email' => $email,
                'password' => $contrasena,
            ])
        ) {
            throw new \Exception('El email o contraseña es incorrecto!', 422);
        }

        $usuario = User::where('email', $email)->first();

        if (!LoginSession::where('user_id', $usuario->id)->whereDate('created_at', Carbon::today())->exists()) {
            LoginSession::create([
                'user_id' => $usuario->id,
                'ip' => null,
                'activo' => true,
                'logged_in_at' => Carbon::now(),
            ]);
        }

        $tokenResult = Auth::guard('web')->user()->createToken('session_token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addDays(1);
        $token->save();

        $user = [
            'permissions' => $usuario->getAllPermissions()->pluck('name'),
            'roles' => $usuario->roles->pluck('name'),
            'id' => $usuario->id,
            'email' => $usuario->email,
            'documento' => $usuario->documento,
            'telefono' => $usuario->telefono,
            'apellidos' => $usuario->apellidos,
            'nombre_completo' => $usuario->nombre_completo
        ];

        return [
            'usuario' => $user,
            'token' => $tokenResult->accessToken,
            'status' => true,
        ];

    }
}