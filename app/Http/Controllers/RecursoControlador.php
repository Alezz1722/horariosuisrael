<?php

namespace App\Http\Controllers;

use App\Models\Recurso;
use App\Models\Actividad;
use App\Models\Periodo;
use Carbon\Carbon;
use Validator;

use Illuminate\Http\Request;

class RecursoControlador extends Controller
{
    public function recurso(Request $request){

        $actividad = Actividad::where('idActividad',$request->id)->first();

        if (session()->has('usuarioConectado') and $actividad != null){
            $idusuario = session('usuarioConectado')['idUsuario'];
            $recursos = Recurso::where('idActividad', '=', $request->id)->get();
            return view('recurso.recurso',compact('recursos','actividad'));
        }else{
            abort(404);
        }
    }

    public function crearRecurso(Request $request){


        if (session()->has('usuarioConectado') and $request->id!= null){
            $actividad = Actividad::where('idActividad',$request->id)->first();
            return view('recurso.crearRecurso',compact('actividad'));
        }else{
            abort(404);
        }
    }

    //Para validar el registro nueva fecha
    public function validaRecurso(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'nombreRecurso' => 'required',
                'urlRecurso' => 'required|url'
            ]);

            if ($validator->passes()) {

                return response()->json(['success'=>'Recurso valido']);

            }else{
                return response()->json(['error'=>$validator->errors()]);
            }

        }
        catch(\Exception  $e)
        {
            return response()->json(['error'=>$e->getMessage()]);
        }

    }

     //Cuando el formulario se encuentra validado
     public function agregarRecurso(Request $request)
     {

         try {
             $recurso = new Recurso();
             $recurso->nombreRecurso=$request->nombreRecurso;
             $recurso->urlRecurso=$request->urlRecurso;
             $recurso->idActividad = $request->idActividad;

             $recurso->save();
             return response()->json(['success'=>'Recurso registrado exitosamente']);
         }
         catch(\Exception  $e)
         {
             return response()->json(['error'=>$e->getMessage()]);
         }

     }

    public function editarRecurso($idRecurso)
    {
        if (session()->has('usuarioConectado') and $idRecurso != null){
            $recurso = Recurso::where('idRecurso',$idRecurso)->first();
            $recurso->idActividad = Actividad::where('idActividad',$recurso->idActividad)->first();
            $recurso->idActividad->idPeriodo = $periodo = Periodo::where('idPeriodo',$recurso->idActividad->idPeriodo)->first();
            return view('recurso.editarRecurso', compact('recurso'));
        }else{
            abort(404);
        }
    }

    public function updateRecurso(Request $request, $idRecurso){


        try {

            $recurso = Recurso::where('idRecurso',$idRecurso)->first();

            $recurso->nombreRecurso=$request->nombreRecurso;
            $recurso->urlRecurso=$request->urlRecurso;

            $recurso->save();

            return response()->json(['success'=>'Recurso editado exitosamente']);

        }
        catch(\Exception  $e)
        {
            return response()->json(['error'=>$e->getMessage()]);
        }

    }

    public function eliminarRecurso($idRecurso){

        try {
            $recurso = Recurso::where('idRecurso',$idRecurso)->first();
            $recurso->delete();

            return response()->json(['success'=>'Recurso eliminado exitosamente']);
        }
        catch(\Exception  $e)
        {
            return response()->json(['error'=>$e->getMessage()]);
        }
    }


}
