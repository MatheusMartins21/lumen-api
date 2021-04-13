<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    protected $jwt;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function usuarioLogin(Request $request) {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if(! $token = $this->jwt->claims(['email' => $request->email])->attempt($request->only('email', 'password')))
        {
            return response()->json(['Usuario não encontrado'], 404);
        }

        return response()->json(compact('token'));
    }

    public function mostrarTodosUsuarios()
    {
        return response()->json(Usuario::all());
    }

    public function cadastrarUsuario(Request $request)
    {
        $this->validate($request, [
            'usuario' => 'required|min:5|max:40',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required'
        ]);

        $usuario = new Usuario;
        $usuario->usuario = $request->usuario;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->save();

        return response()->json($usuario);
    }

    public function mostrarUmUsuario($id)
    {
        return response()->json(Usuario::find($id));
    }

    public function atualizarUsuario($id, Request $request)
    {
        $usuario = Usuario::find($id);

        $usuario->usuario = $request->usuario;
        $usuario->email = $request->email;
        $usuario->password = $request->password;

        $usuario->save();

        return response()->json($usuario);
    }

    public function deletarUsuario($id)
    {
        $usuario = Usuario::find($id);

        $usuario->delete();

        return response()->json('Deletado com Sucesso', 200);
    }

    //
}
