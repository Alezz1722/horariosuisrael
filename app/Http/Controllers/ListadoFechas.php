<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Validator;

class ListadoFechas extends Controller
{
    //Para validar la actualizacion del estado de fechas
    public function validaListadoFecha(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'fechaInicio' => 'required|date',
                'estadoActividad' => 'required',
                'observacion' => 'required',
                'horaInicio' => 'required|date_format:H:i',
                'horaFin' => 'required|date_format:H:i|after:horaInicio'
            ]);

            if ($validator->passes()) {

                return response()->json(['success'=>'Fecha valida']);

            }else{
                return response()->json(['error'=>$validator->errors()]);
            }

        }
        catch(\Exception  $e)
        {
            return response()->json(['error'=>$e->getMessage()]);
        }

    }

}
