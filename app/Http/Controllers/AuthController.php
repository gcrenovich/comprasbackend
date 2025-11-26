<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UsuarioService;

class AuthController extends Controller
{
    protected $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        return $this->usuarioService->login($request->email, $request->password);
    }

    public function logout()
    {
        // Si luego usamos JWT o Sanctum, acá eliminamos tokens
        return response()->json(['message' => 'Logout OK']);
    }
}

