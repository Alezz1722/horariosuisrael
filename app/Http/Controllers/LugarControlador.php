<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;

class LugarControlador extends Controller
{
    public function lugar(Request $request){
        if (session()->has('usuarioConectado')){
            $idusuario = session('usuarioConectado')['idUsuario'];
            $lugares = Lugar::where('idUsuario', '=', $idusuario)->get();
            return view('lugar.lugar',compact('lugares'));
        }else{
            abort(404);
        }
    }

    public function crearLugar(Request $request){
        if (session()->has('usuarioConectado')){
            return view('lugar.crearLugar');
        }else{
            abort(404);
        }
    }

    //Para validar el registro nuevo lugar
    public function validaLugar(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nombreLugar' => 'required',
            'direccionLugar' => 'required',
            'telefonoLugar' => 'required|numeric'
        ]);

        if ($validator->passes()) {

            return response()->json(['success'=>'Lugar valido']);

        }else{
            return response()->json(['error'=>$validator->errors()]);
        }
    }

    //Cuando el formulario se encuentra validado
    public function agregarLugar(Request $request)
    {

        try {
            $lugar = new Lugar();
            $lugar->nombreLugar = $request->nombreLugar;
            $lugar->direccionLugar = $request->direccionLugar;
            $lugar->aulaLugar = $request->aulaLugar;
            $lugar->telefonoLugar = $request->telefonoLugar;
            $lugar->idUsuario = session('usuarioConectado')['idUsuario'];
            $lugar->save();
            return response()->json(['success'=>'Lugar registrado exitosamente']);
        }
        catch(\Exception  $e)
        {
            return response()->json(['error'=>$e->getMessage()]);
        }


    }

    public function editarLugar($idLugar)
    {
        $lugar = Lugar::where('idLugar',$idLugar)->first();
        return view('lugar.editarLugar', compact('lugar'));
    }

    public function updateLugar(Request $request, $idLugar){

        $lugarActualizado = Lugar::where('idLugar',$idLugar)->first();

        $lugarActualizado->nombreLugar = $request->nombreLugar;
        $lugarActualizado->direccionLugar = $request->direccionLugar;
        $lugarActualizado->aulaLugar = $request->aulaLugar;
        $lugarActualizado->telefonoLugar = $request->telefonoLugar;
        $lugarActualizado->save();
        return response()->json(['success'=>'Lugar editado exitosamente']);

    }

    public function eliminarLugar($idLugar){

        try {
            $lugar = Lugar::where('idLugar',$idLugar)->first();
            $lugar->delete();
            return response()->json(['success'=>'Lugar eliminado exitosamente']);
        }
        catch(\Exception  $e)
        {
            return response()->json(['error'=>$e->getMessage()]);
        }
    }

}
