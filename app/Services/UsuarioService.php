<?php

namespace App\Services;

use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioService
{
    /**
     * Login REAL usando la columna "password" de la base de datos.
     */
    public function login($email, $password)
    {
        $usuario = Usuario::where('email', $email)->first();

        if (!$usuario) {
            return response()->json([
                'error' => 'Usuario no encontrado'
            ], 404);
        }

        if (!Hash::check($password, $usuario->password)) {
            return response()->json([
                'error' => 'Credenciales inválidas'
            ], 401);
        }

        unset($usuario->password);

        return response()->json([
            'message' => 'Login OK',
            'usuario' => $usuario
        ]);
    }

    /**
     * Listar usuarios
     */
    public function listar()
    {
        return Usuario::all();
    }

    /**
     * Ver usuario por ID
     */
    public function ver($id)
    {
        return Usuario::findOrFail($id);
    }
}
