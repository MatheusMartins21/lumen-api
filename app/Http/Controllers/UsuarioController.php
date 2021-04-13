<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function mostrarTodosUsuarios()
    {
        return response()->json(Usuario::all());
    }

    public function cadastrarUsuario(Request $request)    
    {
        $usuario = new Usuario;
        $usuario->usuario = $request->usuario;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->save();

        return response()->json($usuario);
    }

    //
}
