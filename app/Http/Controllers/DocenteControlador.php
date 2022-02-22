<?php

namespace App\Http\Controllers;

use App\Models\Periodo;
use App\Models\Listadofechas;
use App\Models\Fecha;
use App\Models\Recurso;
use App\Models\Lugar;
use App\Models\Actividad;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DocenteControlador extends Controller
{
    public function menu(Request $request){
        if (session()->has('usuarioConectado')){



            return view('docente.menuprincipal');

        }else{
            abort(404);
        }
    }

    public function listarHorariosSemanal(Request $request){
        if (session()->has('usuarioConectado')){

            try {

                $fechas = [];
                $period = CarbonPeriod::create($request->fechaInicio,$request->fechaFin);

                foreach ($period as $date) {
                    $lf = ListadoFechas::where('fechaListadoFecha',$date)->orderBy('horaInicioListadoFecha', 'ASC');
                    $listadosfechas = ListadoFechas::where('fechaAplazadaListadoFecha',$date)->orderBy('horaInicioAplazadaListadoFecha', 'ASC')->union($lf)->get();
                    foreach ($listadosfechas as $listadofecha) {
                        if(isset($listadofecha)){
                            $listadofecha->idFecha = Fecha::where('idFecha',$listadofecha->idFecha)->first();
                            $listadofecha->idFecha->idActividad = Actividad::where('idActividad',$listadofecha->idFecha->idActividad )->first();
                            $listadofecha->idFecha->idActividad->idRecurso = Recurso::where('idActividad',$listadofecha->idFecha->idActividad->idActividad )->get();
                            $listadofecha->idFecha->idActividad->idLugar = Lugar::where('idLugar',$listadofecha->idFecha->idActividad->idLugar )->first();
                            $listadofecha->idFecha->idActividad->idPeriodo = Periodo::where('idPeriodo',$listadofecha->idFecha->idActividad->idPeriodo )->first();
                        }
                    }

                    $fechas[substr($date, 0,10)]= $listadosfechas;
                }

                return response()->json(['success'=> $fechas]);

            }catch(\Exception  $e)
            {
                return response()->json(['error'=>$e->getMessage()]);
            }
        }else{
            abort(404);
        }
    }

    public function importarExcel(Request $request){
        if (session()->has('usuarioConectado')){
            $idusuario = session('usuarioConectado')['idUsuario'];
            $periodos = Periodo::where('idUsuario', '=', $idusuario)->get();
            return view('docente.importarExcel',compact('periodos'));
        }else{
            abort(404);
        }
    }

}
