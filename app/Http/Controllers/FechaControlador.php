<?php

namespace App\Http\Controllers;

use App\Models\Fecha;
use App\Models\Actividad;
use App\Models\Periodo;
use App\Models\Listadofechas;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Validator;

class FechaControlador extends Controller
{
    public function fecha(Request $request)
    {

        $actividad = Actividad::where('idActividad', $request->id)->first();

        if (session()->has('usuarioConectado') and $actividad != null) {
            $idusuario = session('usuarioConectado')['idUsuario'];
            $fechas = Fecha::where('idActividad', '=', $request->id)->get();
            return view('fecha.fecha', compact('fechas', 'actividad'));
        } else {
            abort(404);
        }
    }

    public function crearFecha(Request $request)
    {

        $actividad = Actividad::where('idActividad', $request->id)->first();

        if (session()->has('usuarioConectado') and $actividad != null) {
            $periodo = Periodo::where('idPeriodo', $actividad->idPeriodo)->first();
            return view('fecha.crearFecha', compact('actividad', 'periodo'));
        } else {
            abort(404);
        }
    }

    //Para validar el registro nueva fecha
    public function validaFecha(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'fechaInicioFecha' => 'required|date',
                'fechaFinFecha' => 'required|date|after_or_equal:fechaInicioFecha',
                'frecuenciaFecha' => 'required',
                'diaFecha' => 'required',
                'horaInicioFecha' => 'required|date_format:H:i',
                'horaFinFecha' => 'required|date_format:H:i|after:horaInicioFecha'
            ]);

            if ($validator->passes()) {

                return response()->json(['success' => 'Fecha valida']);
            } else {
                return response()->json(['error' => $validator->errors()]);
            }
        } catch (\Exception  $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    //Cuando el formulario se encuentra validado
    public function agregarFecha(Request $request)
    {

        try {

            $fecha = new Fecha();
            $fInicioFecha = Carbon::parse($request->fechaInicioFecha);
            $fecha->fechaInicioFecha = $fInicioFecha->format('Y/m/d H:i:s');
            $fFinFecha = Carbon::parse($request->fechaFinFecha);
            $fecha->fechaFinFecha = $fFinFecha->format('Y/m/d H:i:s');
            $fecha->frecuenciaFecha = $request->frecuenciaFecha;
            $fecha->diaFecha = $request->diaFecha;
            $fHInicioFecha = Carbon::parse($request->horaInicioFecha);
            $fecha->horaInicioFecha = $fHInicioFecha->format('H:i');
            $fHFinFecha = Carbon::parse($request->horaFinFecha);
            $fecha->horaFinFecha = $fHFinFecha->format('H:i');
            $fecha->idActividad = $request->idActividad;
            $fecha->save();


            $dia = "";
            switch ($fecha->diaFecha) {
                case ('lunes'):
                    $dia = "Monday";
                    break;
                case ('Martes'):
                    $dia = "Tuesday";
                    break;
                case ('miercoles'):
                    $dia = "Wednesday";
                    break;
                case ('jueves'):
                    $dia = "Thursday";
                    break;
                case ('viernes'):
                    $dia = "Friday";
                    break;
                case ('sabado'):
                    $dia = "Saturday";
                    break;
                case ('domingo'):
                    $dia = "Sunday";
                    break;
            }

            if ($fecha->frecuenciaFecha == 'frecuenciaUnaVezSemana') {

                $period = CarbonPeriod::create($request->fechaInicioFecha, $request->fechaFinFecha);
                foreach ($period as $date) {
                    if ($dia == $date->format('l')) {


                        $periodo = CarbonPeriod::create($date, '7 days', $request->fechaFinFecha);

                        foreach ($periodo as $date) {
                            $listadofecha = new Listadofechas();
                            $listadofecha->fechaListadoFecha = $date;
                            $fHInicioFecha = Carbon::parse($request->horaInicioFecha);
                            $listadofecha->horaInicioListadoFecha = $fHInicioFecha->format('H:i');
                            $fHFinFecha = Carbon::parse($request->horaFinFecha);
                            $listadofecha->horaFinListadoFecha = $fHFinFecha->format('H:i');
                            $listadofecha->idFecha = $fecha->idFecha;
                            $listadofecha->idUsuario = session('usuarioConectado')['idUsuario'];
                            $listadofecha->estadoListadoFecha = "ACTIVA";
                            $listadofecha->observacionListadoFecha = "";
                            $listadofecha->save();
                        }
                        break;
                    }
                }
            } else
            if ($fecha->frecuenciaFecha == 'frecuenciaUnaVez') {

                $listadofecha = new Listadofechas();
                $listadofecha->fechaListadoFecha = Carbon::parse($request->fechaInicioFecha)->format('Y/m/d H:i:s');
                $fHInicioFecha = Carbon::parse($request->horaInicioFecha);
                $listadofecha->horaInicioListadoFecha = $fHInicioFecha->format('H:i');
                $fHFinFecha = Carbon::parse($request->horaFinFecha);
                $listadofecha->horaFinListadoFecha = $fHFinFecha->format('H:i');
                $listadofecha->idFecha = $fecha->idFecha;
                $listadofecha->idUsuario = session('usuarioConectado')['idUsuario'];
                $listadofecha->estadoListadoFecha = "ACTIVA";
                $listadofecha->observacionListadoFecha = "";
                $listadofecha->save();
            }
            return response()->json(['success' => 'Fecha editada exitosamente']);
        } catch (\Exception  $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function editarFecha($idFecha)
    {
        if (session()->has('usuarioConectado') and $idFecha != null) {
            $fecha = Fecha::where('idFecha', $idFecha)->first();
            $fecha->idActividad = Actividad::where('idActividad', $fecha->idActividad)->first();
            $fecha->idActividad->idPeriodo = $periodo = Periodo::where('idPeriodo', $fecha->idActividad->idPeriodo)->first();
            return view('fecha.editarFecha', compact('fecha'));
        } else {
            abort(404);
        }
    }

    public function updateFecha(Request $request, $idFecha)
    {


        try {

            $listadofecha = ListadoFechas::where('idFecha', $idFecha);
            $listadofecha->delete();

            $fecha = Fecha::where('idFecha', $idFecha)->first();

            $fInicioFecha = Carbon::parse($request->fechaInicioFecha);
            $fecha->fechaInicioFecha = $fInicioFecha->format('Y/m/d H:i:s');
            $fFinFecha = Carbon::parse($request->fechaFinFecha);
            $fecha->fechaFinFecha = $fFinFecha->format('Y/m/d H:i:s');
            $fecha->frecuenciaFecha = $request->frecuenciaFecha;
            $fecha->diaFecha = $request->diaFecha;
            $fHInicioFecha = Carbon::parse($request->horaInicioFecha);
            $fecha->horaInicioFecha = $fHInicioFecha->format('H:i');
            $fHFinFecha = Carbon::parse($request->horaFinFecha);
            $fecha->horaFinFecha = $fHFinFecha->format('H:i');

            $fecha->save();


            $dia = "";
            switch ($fecha->diaFecha) {
                case ('lunes'):
                    $dia = "Monday";
                    break;
                case ('martes'):
                    $dia = "Tuesday";
                    break;
                case ('miercoles'):
                    $dia = "Wednesday";
                    break;
                case ('jueves'):
                    $dia = "Thursday";
                    break;
                case ('viernes'):
                    $dia = "Friday";
                    break;
                case ('sabado'):
                    $dia = "Saturday";
                    break;
                case ('domingo'):
                    $dia = "Sunday";
                    break;
            }

            if ($fecha->frecuenciaFecha == 'frecuenciaUnaVezSemana') {

                $period = CarbonPeriod::create($request->fechaInicioFecha, $request->fechaFinFecha);
                foreach ($period as $date) {
                    if ($dia == $date->format('l')) {


                        $periodo = CarbonPeriod::create($date, '7 days', $request->fechaFinFecha);

                        foreach ($periodo as $date) {
                            $listadofecha = new Listadofechas();
                            $listadofecha->fechaListadoFecha = $date;
                            $fHInicioFecha = Carbon::parse($request->horaInicioFecha);
                            $listadofecha->horaInicioListadoFecha = $fHInicioFecha->format('H:i');
                            $fHFinFecha = Carbon::parse($request->horaFinFecha);
                            $listadofecha->horaFinListadoFecha = $fHFinFecha->format('H:i');
                            $listadofecha->idFecha = $fecha->idFecha;
                            $listadofecha->idUsuario = session('usuarioConectado')['idUsuario'];
                            $listadofecha->observacionListadoFecha = "";
                            $listadofecha->estadoListadoFecha = "ACTIVA";
                            $listadofecha->save();
                        }
                        break;
                    }
                }
            } else
            if ($fecha->frecuenciaFecha == 'frecuenciaUnaVez') {

                $period = CarbonPeriod::create($request->fechaInicioFecha, $request->fechaFinFecha);
                foreach ($period as $date) {
                    if ($dia == $date->format('l')) {

                        $listadofecha = new Listadofechas();
                        $listadofecha->fechaListadoFecha = $date;
                        $fHInicioFecha = Carbon::parse($request->horaInicioFecha);
                        $listadofecha->horaInicioListadoFecha = $fHInicioFecha->format('H:i');
                        $fHFinFecha = Carbon::parse($request->horaFinFecha);
                        $listadofecha->horaFinListadoFecha = $fHFinFecha->format('H:i');
                        $listadofecha->idFecha = $fecha->idFecha;
                        $listadofecha->idUsuario = session('usuarioConectado')['idUsuario'];
                        $listadofecha->observacionListadoFecha = "";
                        $listadofecha->estadoListadoFecha = "ACTIVA";
                        $listadofecha->save();
                        break;
                    }
                }
                $dates = $period->toArray();
            }

            return response()->json(['success' => 'Fecha editada exitosamente']);
        } catch (\Exception  $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function eliminarFecha($idFecha)
    {

        try {
            $listadofecha = ListadoFechas::where('idFecha', $idFecha);
            $fecha = Fecha::where('idFecha', $idFecha)->first();
            $listadofecha->delete();
            $fecha->delete();

            return response()->json(['success' => 'Horario eliminado exitosamente']);
        } catch (\Exception  $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function editarListadoFecha(Request $request)
    {

        try {
            $listadofecha = ListadoFechas::where('idListadoFecha', ($request->idListadoFecha))->first();
            if ($request->estadoActividad == "ACTIVA") {

                $listadofecha->estadoListadoFecha = $request->estadoActividad;
                $listadofecha->fechaAplazadaListadoFecha = NULL;
                $listadofecha->horaInicioAplazadaListadoFecha = NULL;
                $listadofecha->horaFinAplazadaListadoFecha = NULL;
                $listadofecha->observacionListadoFecha = "";
            } else
            if ($request->estadoActividad == "APLAZADA") {
                $listadofecha->estadoListadoFecha = $request->estadoActividad;
                $listadofecha->fechaAplazadaListadoFecha = Carbon::parse($request->fechaInicio)->format('Y/m/d H:i:s');
                $listadofecha->horaInicioAplazadaListadoFecha = Carbon::parse($request->horaInicio)->format('H:i');
                $listadofecha->horaFinAplazadaListadoFecha = Carbon::parse($request->horaFin)->format('H:i');
                $listadofecha->observacionListadoFecha = $request->observacion;
            } else
            if ($request->estadoActividad == "CANCELADA") {
                $listadofecha->estadoListadoFecha = $request->estadoActividad;
                $listadofecha->fechaAplazadaListadoFecha = NULL;
                $listadofecha->horaInicioAplazadaListadoFecha = NULL;
                $listadofecha->horaFinAplazadaListadoFecha = NULL;
                $listadofecha->observacionListadoFecha = $request->observacion;
            }
            $listadofecha->save();
            return response()->json(['success' => 'Listado fecha registrada exitosamente']);
        } catch (\Exception  $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
