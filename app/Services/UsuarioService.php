<?php

namespace App\Services;

use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioService
{
    /**
     * Login simple sin JWT (por ahora)
     */
    public function login($email, $password)
    {
        $usuario = Usuario::where('email', $email)->first();

        if (!$usuario) {
            return response()->json([
                'error' => 'Usuario no encontrado'
            ], 404);
        }

        // ⚠️ Por ahora no usamos password real, porque tu tabla usuarios NO TIENE campo password
        // Así que por ahora validamos "abc123" como clave global temporal

        if ($password !== 'abc123') {
            return response()->json([
                'error' => 'Credenciales inválidas'
            ], 401);
        }

        return response()->json([
            'message' => 'Login OK',
            'usuario' => $usuario
        ]);
    }


    /**
     * Listar todos los usuarios
     */
    public function listar()
    {
        return Usuario::all();
    }

    /**
     * Buscar usuario por ID
     */
    public function ver($id)
    {
        return Usuario::findOrFail($id);
    }
}
