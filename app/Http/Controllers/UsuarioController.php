<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Listar todos los usuarios
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

    /**
     * Crear usuario
     */
    public function crear(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string',
            'email'           => 'required|email|unique:usuarios,email',
            'id_sector'       => 'nullable|integer',
            'rol'             => 'required|string',
            'password'        => 'required|string|min:4'
        ]);

        $usuario = Usuario::create([
            'nombre_completo'      => $request->nombre_completo,
            'email'                => $request->email,
            'id_sector'            => $request->id_sector,
            'rol'                  => $request->rol,
            'puede_aprobar_nivel1' => $request->puede_aprobar_nivel1 ?? false,
            'puede_aprobar_nivel2' => $request->puede_aprobar_nivel2 ?? false,
            'activo'               => true,
            'password'             => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Usuario creado correctamente',
            'usuario' => $usuario
        ]);
    }

    /**
     * Actualizar usuario
     */
    public function actualizar($id, Request $request)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'email' => 'email|unique:usuarios,email,' . $usuario->id_usuario . ',id_usuario'
        ]);

        $usuario->update($request->all());

        return response()->json([
            'message' => 'Usuario actualizado',
            'usuario' => $usuario
        ]);
    }

    /**
     * Desactivar usuario
     */
    public function desactivar($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->activo = false;
        $usuario->save();

        return response()->json(['message' => 'Usuario desactivado']);
    }
}
