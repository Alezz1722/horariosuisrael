@extends('plantilla')

@section('contenidoPrincipal')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-clipboard-list"></i> Horarios establecidos para la actividad "{{$actividad->nombreActividad}}"  de {{ session('usuarioConectado')['nombreUsuario'] }} {{ session('usuarioConectado')['apellidoUsuario'] }} </span>
                    <input type="text" class="form-control" id="idActividad" name="idActividad" value="{{ $actividad->idActividad }}" hidden>
                    <a href="{{ route('crearFecha', [ 'id' => $actividad->idActividad]) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle"></i> Nuevo Horario</a>
                </div>
                <div class="card-body">
                    <div style="display: none">{{ $cont =0 }}</div>
                    @if (count($fechas) > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">F.Inicio</th>
                                <th scope="col">F.Fin</th>
                                <th scope="col">Día</th>
                                <th scope="col">H.Inicio</th>
                                <th scope="col">H.Fin</th>
                                <th scope="col">Frecuencia</th>
                                <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fechas as $fecha)
                                <tr>
                                    <th scope="row">{{ ++$cont }}</th>
                                    <td>{{ $fecha->fechaInicioFecha }}</td>
                                    <td>{{ $fecha->fechaFinFecha }}</td>
                                    <td>
                                        @if ( $fecha->diaFecha  == "lunes")
                                            Lunes
                                        @elseif ( $fecha->diaFecha  == "martes")
                                            Martes
                                        @elseif ( $fecha->diaFecha  == "miercoles")
                                            Miercoles
                                        @elseif ( $fecha->diaFecha  == "jueves")
                                            Jueves
                                        @elseif ( $fecha->diaFecha  == "viernes")
                                            Viernes
                                        @elseif ( $fecha->diaFecha  == "sabado")
                                            Sábado
                                        @elseif ( $fecha->diaFecha  == "domingo")
                                            Domingo
                                        @endif
                                    </td>
                                    <td>{{ $fecha->horaInicioFecha }}</td>
                                    <td>{{ $fecha->horaFinFecha }}</td>
                                    <td>
                                        @if ( $fecha->frecuenciaFecha  == "frecuenciaUnaVez")
                                            Una vez
                                        @elseif ( $fecha->frecuenciaFecha  == "frecuenciaUnaVezSemana")
                                            Una vez a la semana
                                        @endif

                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{route('editarFecha', $fecha->idFecha)}}" class="btn btn-warning">Editar</a>
                                            <a class="btn btn-danger borrarFecha">
                                                <p class="idFecha" hidden>{{$fecha->idFecha}}</p>
                                                Borrar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    @if (count($fechas) == 0)
                        <h5><center>No existen horarios registrados</center></h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/fecha/lstFecha.js') }}"></script>
@endsection
