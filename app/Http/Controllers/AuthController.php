<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // validar datos
        $request->validate([
            "email" => "required|string|email",
            "password" => "required|string"
        ]);
        //verficar el correo
        $usuario = User::where('email', $request->email)->first();
        //verificar el password
        $pass = $request->password;
        if(!$usuario || !Hash::check($pass, $usuario->password)){
            return response()->json(["mensaje" => "Credenciales Incorrectas"], 403);
        }
        // generar el token
        $token = $usuario->createToken('mi_token')->plainTextToken;
        // return
        return response()->json([
            "usuario" => $usuario,
            "token" => $token
        ], 200);
        
    }

    public function logout()
    {
        
    }

    public function perfil()
    {
        return response()->json(Auth::user(), 200);
    }
    
    // refresh token
    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        // generar el token
        $token = $user->createToken($user->name)->plainTextToken;
        // return
        return response()->json([
            "usuario" => $user,
            "token" => $token
        ], 200);
    }

}
