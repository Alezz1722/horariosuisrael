<?php

namespace App\Http\Controllers;

use App\Models\Periodo;
use App\Models\Listadofechas;
use App\Models\Fecha;
use App\Models\Recurso;
use App\Models\Lugar;
use App\Models\Usuario;
use App\Models\Actividad;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class DocenteControlador extends Controller
{
    public function menu(Request $request)
    {

        if (session()->has('usuarioConectado')) {
            return view('docente.menuprincipal');
        } else {
            $docentes = Usuario::get();
            return view('docente.index', compact('docentes'));
        }
    }


    public function registraDocente(Request $request)
    {
        return view('docente.registrarse');
    }


    public function nuevoUsuario(Request $request)
    {
        $usuario = Usuario::where('correoUsuario',$request->correoUsuario)->first();

        if(!$usuario){

            $codigoGenerado = Str::random(10);
            Usuario::create([
                'nombreUsuario' => $request->nombreUsuario,
                'apellidoUsuario' => $request->apellidoUsuario,
                'correoUsuario' => $request->correoUsuario,
                'contrasenaUsuario' => md5($request->contrasenaUsuario),
                'estadoUsuario' => 0,
                'codigoUsuario' => $codigoGenerado,
            ]);

            $correo = $request->correoUsuario;
            $data = [   'link' => 'http://127.0.0.1:8000/docente/'.$codigoGenerado,
                'nombre' => $request->nombreUsuario.' '.$request->apellidoUsuario,
                'correo' => $correo,
            ];

            Mail::send('emails.nuevoDocente', $data, function ($message) use ($correo) {
                $message->from('docenciasystem@gmail.com', 'SISTEMA DOCENCIA');
                $message->to($correo)->subject('Confirmación de registro de cuenta');
            });


            return back()->with('success', 'Hemos recibido tu petición de creación, por favor revisa tu correo electrónico para culminar la creación del docente.');
        }else{
            return back()->with('error', 'El docente ya se encuentra registrado');
        }

        return back()->with('error', 'Error de servidor');

    }

    public function recuperaContrasena(Request $request)
    {

        $usuario = Usuario::where('correoUsuario', $request->correoRecuperacion)->first();

        if ($usuario) {

            $codigoGenerado = Str::random(10);
            $correo = $usuario->correoUsuario;

            $usuario->codigoUsuario = $codigoGenerado;
            $usuario->save();

            $data = [
                'link' => 'http://127.0.0.1:8000/password/' . $codigoGenerado,
                'nombre' => $usuario->nombreUsuario . ' ' . $usuario->apellidoUsuario,
                'correo' => $correo,
            ];

            Mail::send('emails.notificacion', $data, function ($message) use ($correo) {
                $message->from('docenciasystem@gmail.com', 'SISTEMA DOCENCIA');
                $message->to($correo)->subject('Recuperación de contraseña');
            });

            //$request->session()->put('usuarioConectado',$emprendedor);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => true]);
        }
    }


    public function restauraContrasena(Request $request, $codigo)
    {

        $usuario = Usuario::where('codigoUsuario', $codigo)->first();

        if ($usuario) {
            return view('docente.restaura', compact('usuario'));
        } else {
            return redirect()->route('menu');
        }
    }

    public function cambiaNuevaContrasena(Request $request, $codigo)
    {

        $usuario = Usuario::where('codigoUsuario', $codigo)->first();

        if ($usuario) {

            $usuario->codigoUsuario = "";
            $usuario->contrasenaUsuario = md5($request->contrasenaUsuario);
            $usuario->estadoUsuario = true;
            $usuario->save();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => true]);
        }
    }


    public function confirmaUsuario(Request $request,$codigo){

        $usuario = Usuario::where('codigoUsuario',$codigo)->first();

        if($usuario){

            $usuario->codigoUsuario = "";
            $usuario->estadoUsuario = true;
            $usuario->save();
            $request->session()->put('usuarioConectado',$usuario);
            return view('docente.bienvenida',compact('usuario'));

        }else{
            return redirect()->route('menu');
        }
    }

    public function listarHorariosSemanal(Request $request)
    {
        if (session()->has('usuarioConectado')) {

            try {

                $fechas = [];
                $period = CarbonPeriod::create($request->fechaInicio, $request->fechaFin);

                foreach ($period as $date) {
                    $lf = ListadoFechas::where('fechaListadoFecha', $date)->where('idUsuario', session('usuarioConectado')['idUsuario'])->orderBy('horaInicioListadoFecha', 'ASC');
                    $lfs = ListadoFechas::where('fechaAplazadaListadoFecha', $date)->where('idUsuario', session('usuarioConectado')['idUsuario'])->orderBy('horaInicioAplazadaListadoFecha', 'ASC');
                    $listadosfechas = $lfs->union($lf)->get();
                    foreach ($listadosfechas as $listadofecha) {
                        if (isset($listadofecha)) {
                            $listadofecha->idFecha = Fecha::where('idFecha', $listadofecha->idFecha)->first();
                            $listadofecha->idFecha->idActividad = Actividad::where('idActividad', $listadofecha->idFecha->idActividad)->first();
                            $listadofecha->idFecha->idActividad->idRecurso = Recurso::where('idActividad', $listadofecha->idFecha->idActividad->idActividad)->get();
                            $listadofecha->idFecha->idActividad->idLugar = Lugar::where('idLugar', $listadofecha->idFecha->idActividad->idLugar)->first();
                            $listadofecha->idFecha->idActividad->idPeriodo = Periodo::where('idPeriodo', $listadofecha->idFecha->idActividad->idPeriodo)->first();
                        }
                    }

                    $fechas[substr($date, 0, 10)] = $listadosfechas;
                }

                return response()->json(['success' => $fechas]);
            } catch (\Exception  $e) {
                return response()->json(['error' => $e->getMessage()]);
            }
        } else {
            try {

                $fechas = [];
                $activa = 0;
                $aplazada = 0;
                $cancelada = 0;
                $period = CarbonPeriod::create($request->fechaInicio, $request->fechaFin);

                foreach ($period as $date) {
                    $lf = ListadoFechas::where('fechaListadoFecha', $date)
                        ->where('idUsuario', $request->idUsuario)
                        ->orderBy('horaInicioListadoFecha', 'ASC');
                    $listadosfechas = ListadoFechas::where('fechaAplazadaListadoFecha', $date)->where('idUsuario', $request->idUsuario)->orderBy('horaInicioAplazadaListadoFecha', 'ASC')->union($lf)->get();
                    foreach ($listadosfechas as $listadofecha) {
                        if (isset($listadofecha)) {
                            $listadofecha->idFecha = Fecha::where('idFecha', $listadofecha->idFecha)->first();
                            $listadofecha->idFecha->idActividad = Actividad::where('idActividad', $listadofecha->idFecha->idActividad)->first();
                            $listadofecha->idFecha->idActividad->idRecurso = Recurso::where('idActividad', $listadofecha->idFecha->idActividad->idActividad)->get();
                            $listadofecha->idFecha->idActividad->idLugar = Lugar::where('idLugar', $listadofecha->idFecha->idActividad->idLugar)->first();
                            $listadofecha->idFecha->idActividad->idPeriodo = Periodo::where('idPeriodo', $listadofecha->idFecha->idActividad->idPeriodo)->first();

                            //if($listadofecha->estadoListadoFecha == 'ACTIVA'){ $activa++;}
                            //if($listadofecha->estadoListadoFecha == 'APLAZADA'){ $aplazada++;}
                            //if($listadofecha->estadoListadoFecha == 'CANCELADA'){ $cancelada++;}
                        }
                    }

                    $fechas[substr($date, 0, 10)] = $listadosfechas;
                }

                return response()->json(['success' => $fechas]);
            } catch (\Exception  $e) {
                return response()->json(['error' => $e->getMessage()]);
            }
        }
    }

    public function importarExcel(Request $request)
    {
        if (session()->has('usuarioConectado')) {
            $idusuario = session('usuarioConectado')['idUsuario'];
            $periodos = Periodo::where('idUsuario', '=', $idusuario)->get();
            return view('docente.importarExcel', compact('periodos'));
        } else {
            abort(404);
        }
    }

    public function importarExcelActividad(Request $request)
    {
        if (session()->has('usuarioConectado')) {
            try {
                $periodo = Periodo::where('idPeriodo', '=', $request->idperiodo)->first();
                $actividades = $request->actividades;
                foreach ($actividades as $actividad) {
                    $lugar = Lugar::where('nombreLugar', '=', $actividad['LUGAR'])->where('aulaLugar', '=', $actividad['AULA'])->first();
                    if (!$lugar) {
                        $lugar = new Lugar();
                        $lugar->nombreLugar = $actividad['LUGAR'];
                        $lugar->direccionLugar = "S/D";
                        $lugar->aulaLugar = $actividad['AULA'];
                        $lugar->telefonoLugar = "S/T";
                        $lugar->idUsuario = session('usuarioConectado')['idUsuario'];
                        $lugar->save();
                    }

                    $act = Actividad::where('nombreActividad', '=', $actividad['MATERIA'])
                        ->where('idLugar', '=', $lugar->idLugar)
                        ->where('idPeriodo', '=', $periodo->idPeriodo)
                        ->first();

                    if (!$act) {
                        $act = new Actividad();
                        $act->nombreActividad = $actividad['MATERIA'];
                        $act->descripcionActividad = "S/D";
                        $act->idUsuario = session('usuarioConectado')['idUsuario'];
                        $act->idPeriodo = $periodo->idPeriodo;
                        $act->idLugar = $lugar->idLugar;
                        $act->save();
                    }

                    $horas = explode(" ", $actividad['HORA']);
                    $horas[0] = Carbon::parse($horas[0])->format('H:i');
                    $horas[1] = Carbon::parse($horas[1])->format('H:i');

                    $fecha = Fecha::where('idActividad', '=', $act->idActividad)
                        ->where('diaFecha', '=', strtolower($actividad['DIA']))
                        ->where('horaInicioFecha', '=', $horas[0])
                        ->where('horaFinFecha', '=', $horas[1])
                        ->where('fechaInicioFecha', '=', Carbon::parse($periodo->fechaInicioPeriodo))
                        ->where('fechaFinFecha', '=', Carbon::parse($periodo->fechaFinPeriodo))
                        ->first();

                    if (!$fecha) {
                        $fecha = new Fecha();
                        $fecha->fechaInicioFecha = $periodo->fechaInicioPeriodo;
                        $fecha->fechaFinFecha = $periodo->fechaFinPeriodo;
                        $fecha->horaInicioFecha = $horas[0];
                        $fecha->horaFinFecha = $horas[1];
                        $fecha->diaFecha = strtolower($actividad['DIA']);
                        $fecha->frecuenciaFecha = "frecuenciaUnaVezSemana";
                        $fecha->idActividad = $act->idActividad;
                        $fecha->save();
                    }

                    $dia = "";
                    switch (strtolower($actividad['DIA'])) {
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

                    $period = CarbonPeriod::create($periodo->fechaInicioPeriodo, $periodo->fechaFinPeriodo);

                    foreach ($period as $date) {
                        if ($dia == $date->format('l')) {

                            $p = CarbonPeriod::create($date, '7 days', $periodo->fechaFinPeriodo);

                            foreach ($p as $date) {

                                $lf = Listadofechas::where('fechaListadoFecha', '=', $date)
                                    ->where('idFecha', '=', $fecha->idFecha)
                                    ->where('horaInicioListadoFecha', '=', $horas[0])
                                    ->where('horaFinListadoFecha', '=', $horas[1])
                                    ->where('idUsuario', '=', session('usuarioConectado')['idUsuario'])
                                    ->first();

                                if (!$lf) {
                                    $listadofecha = new Listadofechas();
                                    $listadofecha->fechaListadoFecha = $date;
                                    $listadofecha->horaInicioListadoFecha = $horas[0];
                                    $listadofecha->horaFinListadoFecha = $horas[1];
                                    $listadofecha->idFecha = $fecha->idFecha;
                                    $listadofecha->idUsuario = session('usuarioConectado')['idUsuario'];
                                    $listadofecha->estadoListadoFecha = "ACTIVA";
                                    $listadofecha->observacionListadoFecha = "";
                                    $listadofecha->save();
                                }
                            }
                            break;
                        }
                    }
                }
                return response()->json(['success' => $actividad]);
            } catch (\Exception  $e) {
                return response()->json(['error' => $e->getMessage()]);
            }
        } else {
            abort(404);
        }
    }
}
