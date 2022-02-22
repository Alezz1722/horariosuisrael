<?php

namespace App\Http\Controllers;

use App\Models\Periodo;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;

class PeriodoControlador extends Controller
{
    public function periodo(Request $request){
        if (session()->has('usuarioConectado')){
            $idusuario = session('usuarioConectado')['idUsuario'];
            $periodos = Periodo::where('idUsuario', '=', $idusuario)->get();
            return view('periodo.periodo',compact('periodos'));
        }else{
            abort(404);
        }
    }

    public function crearPeriodo(Request $request){
        if (session()->has('usuarioConectado')){
            return view('periodo.crearPeriodo');
        }else{
            abort(404);
        }
    }

    //Para validar el registro nuevo periodo
    public function validaPeriodo(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nombrePeriodo' => 'required',
            'descripcionPeriodo' => 'required',
            'fechaInicioPeriodo' => 'required|date',
            'fechaFinPeriodo' => 'required|date|after_or_equal:fechaInicioPeriodo'
        ]);

        if ($validator->passes()) {

            return response()->json(['success'=>'Periodo valido']);

        }else{
            return response()->json(['error'=>$validator->errors()]);
        }
    }

    //Cuando el formulario se encuentra validado
    public function agregarPeriodo(Request $request)
    {
        $periodo = new Periodo();
        $periodo->nombrePeriodo = $request->nombrePeriodo;
        $periodo->descripcionPeriodo = $request->descripcionPeriodo;
        $fInicioPeriodo = Carbon::parse($request->fechaInicioPeriodo);
        $periodo->fechaInicioPeriodo=$fInicioPeriodo->format('Y/m/d H:i:s');
        $fFinPeriodo = Carbon::parse($request->fechaFinPeriodo);
        $periodo->fechaFinPeriodo=$fFinPeriodo->format('Y/m/d H:i:s');
        $periodo->idUsuario = session('usuarioConectado')['idUsuario'];
        $periodo->save();
        return response()->json(['success'=>'Periodo registrado exitosamente']);
    }


    public function editarPeriodo($idPeriodo)
    {
        $periodo = Periodo::where('idPeriodo',$idPeriodo)->first();
        return view('periodo.editarPeriodo', compact('periodo'));
    }

    public function updatePeriodo(Request $request, $idPeriodo){

        $periodoActualizado = Periodo::where('idPeriodo',$idPeriodo)->first();

        $periodoActualizado->nombrePeriodo = $request->nombrePeriodo;
        $periodoActualizado->descripcionPeriodo = $request->descripcionPeriodo;
        $fInicioPeriodo = Carbon::parse($request->fechaInicioPeriodo);
        $periodoActualizado->fechaInicioPeriodo=$fInicioPeriodo->format('Y/m/d H:i:s');
        $fFinPeriodo = Carbon::parse($request->fechaFinPeriodo);
        $periodoActualizado->fechaFinPeriodo=$fFinPeriodo->format('Y/m/d H:i:s');
        $periodoActualizado->save();

        return response()->json(['success'=>'Periodo editado exitosamente']);

    }

    public function eliminarPeriodo($idPeriodo){

        try {
            $periodo = Periodo::where('idPeriodo',$idPeriodo)->first();
            $periodo->delete();

            return response()->json(['success'=>'Periodo eliminado exitosamente']);
        }
        catch(\Exception  $e)
        {
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
}
