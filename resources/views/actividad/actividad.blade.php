@extends('plantilla')

@section('contenidoPrincipal')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-clipboard-list"></i> Lista de actividades para {{ session('usuarioConectado')['nombreUsuario'] }} {{ session('usuarioConectado')['apellidoUsuario'] }} </span>
                    <a href="{{ route('crearActividad') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle"></i> Nueva actividad</a>
                </div>
                <div class="card-body">
                    <div style="display: none">{{ $cont =0 }}</div>
                    @if (count($actividades) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Periodo</th>
                                <th scope="col">Lugar</th>
                                <th scope="col">Horarios</th>
                                <th scope="col">Recursos</th>
                                <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($actividades as $actividad)
                                <tr>
                                    <th scope="row">{{ ++$cont }}</th>
                                    <td>{{ $actividad->nombreActividad }}</td>
                                    <td>{{ $actividad->descripcionActividad }}</td>
                                    <td>{{ $actividad->idPeriodo->nombrePeriodo }}</td>
                                    <td>{{ $actividad->idLugar->nombreLugar }} ({{ $actividad->idLugar->aulaLugar }})</td>
                                    <td>
                                        <center>
                                            <div class="btn-group">
                                                <center><a href="{{route('fecha', [ 'id' => $actividad->idActividad] )}}" class="btn btn-warning"><i class="fas fa-search"></i></a>
                                            </div>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <div class="btn-group">
                                                <center><a href="{{route('recurso', [ 'id' => $actividad->idActividad] )}}" class="btn btn-warning"><i class="fas fa-search"></i></a>
                                            </div>
                                        </center>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{route('editarActividad', $actividad->idActividad)}}" class="btn btn-warning">Editar</a>
                                            <a class="btn btn-danger borrarActividad">
                                                <p class="idActividad" hidden>{{$actividad->idActividad}}</p>
                                                <p class="nombreActividad" hidden>{{$actividad->nombreActividad}}</p>
                                                Borrar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    @if (count($actividades) == 0)
                        <h5><center>No existen actividades registradas</center></h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/actividad/lstActividad.js') }}"></script>
@endsection
