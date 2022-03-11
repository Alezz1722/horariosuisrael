<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class LoginControlador extends Controller
{
    public function login(){
        return view('login');
    }

    public function cerrarSesion(){
        session()->pull('usuarioConectado');
        return redirect()->route('menu');
    }


    public function acceso(Request $request){
        // return $request->all();

        $request->validate([
            'correo'=> 'required',
            'contrasena'=>'required'
        ]);



        try {
            $usuario = Usuario::select('*')
            ->where('correoUsuario', '=',$request->correo)
            ->where('contrasenaUsuario', '=',md5($request->contrasena))
            ->get()->first();

            if($usuario){//Cuando fue encontrado el usuario
                $request->session()->put('usuarioConectado',$usuario);
                return redirect()->route('menu');
                //return back()->with('mensaje', 'El usuario fue encontrado');
            }else{
                return back()->with('mensajeError', 'El nombre de usuario y/o contraseña no fue el correcto.');

            }
        }
        catch(\Exception  $e)
        {
            //return response()->json(['error'=>$e->getMessage()]);
            return back()->with('mensajeError', $e->getMessage());
        }
    }



}
