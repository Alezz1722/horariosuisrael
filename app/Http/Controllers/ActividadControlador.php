<?php

namespace App\Http\Controllers;


use App\Models\Actividad;
use App\Models\Periodo;
use App\Models\Lugar;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;

class ActividadControlador extends Controller
{
    public function actividad(Request $request)
    {
        if (session()->has('usuarioConectado')) {
            $idusuario = session('usuarioConectado')['idUsuario'];
            $actividades = Actividad::where('idUsuario', '=', $idusuario)->get();
            foreach ($actividades as $actividad) {
                $periodo = Periodo::where('idPeriodo', $actividad->idPeriodo)->first();
                $actividad->idPeriodo = $periodo;
                $lugar = Lugar::where('idLugar', $actividad->idLugar)->first();
                $actividad->idLugar = $lugar;
            }
            return view('actividad.actividad', compact('actividades'));
        } else {
            return redirect()->route('menu');
        }
    }

    public function crearActividad(Request $request)
    {
        if (session()->has('usuarioConectado')) {
            $idusuario = session('usuarioConectado')['idUsuario'];
            $periodos = Periodo::where('idUsuario', '=', $idusuario)->get();
            $lugares = Lugar::where('idUsuario', '=', $idusuario)->get();
            return view('actividad.crearActividad', compact('periodos', 'lugares'));
        } else {
            return redirect()->route('menu');
        }
    }

    //Para validar el registro nueva actividad
    public function validaActividad(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nombreActividad' => 'required',
            'idPeriodo' => 'required',
            'idLugar' => 'required'
        ]);

        if ($validator->passes()) {

            return response()->json(['success' => 'Actividad valida']);
        } else {
            return response()->json(['error' => $validator->errors()]);
        }
    }

    //Cuando el formulario se encuentra validado
    public function agregarActividad(Request $request)
    {
        $actividad = new Actividad();
        $actividad->nombreActividad = $request->nombreActividad;
        $actividad->descripcionActividad = $request->descripcionActividad;
        $actividad->idPeriodo = $request->idPeriodo;
        $actividad->idLugar = $request->idLugar;
        $actividad->idUsuario = session('usuarioConectado')['idUsuario'];
        $actividad->save();
        return response()->json(['success' => 'Actividad registrada exitosamente']);
    }

    public function editarActividad($idActividad)
    {
        if (session()->has('usuarioConectado')) {

            $idusuario = session('usuarioConectado')['idUsuario'];
            $actividad = Actividad::where('idActividad', $idActividad)->first();
            $periodos = Periodo::where('idUsuario', '=', $idusuario)->get();
            $lugares = Lugar::where('idUsuario', '=', $idusuario)->get();


            return view('actividad.editarActividad', compact('actividad', 'periodos', 'lugares'));
        } else {
            return redirect()->route('menu');
        }
    }

    public function updateActividad(Request $request, $idActividad)
    {

        $actividadActualizado = Actividad::where('idActividad', $idActividad)->first();
        $actividadActualizado->nombreActividad = $request->nombreActividad;
        $actividadActualizado->descripcionActividad = $request->descripcionActividad;
        $periodo = Periodo::where('idPeriodo', $request->idPeriodo)->first();
        $actividadActualizado->idPeriodo = $periodo->idPeriodo;
        $lugar = Lugar::where('idLugar', $request->idLugar)->first();
        $actividadActualizado->idLugar = $lugar->idLugar;
        $actividadActualizado->save();
        return response()->json(['success' => 'Actividad editada exitosamente']);
    }

    public function eliminarActividad($idActividad)
    {

        try {
            $actividad = Actividad::where('idActividad', $idActividad)->first();
            $actividad->delete();
            return response()->json(['success' => 'Actividad eliminada exitosamente']);
        } catch (\Exception  $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
