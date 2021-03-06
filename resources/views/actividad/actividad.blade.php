@extends('plantilla')

@section('contenidoPrincipal')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-clipboard-list"></i> Lista de actividades para
                            {{ session('usuarioConectado')['nombreUsuario'] }}
                            {{ session('usuarioConectado')['apellidoUsuario'] }} </span>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('importarExcel') }}" type="button" class="btn btn-success"><i class="bi bi-filetype-xls"></i> Importar</a>
                            <a href="{{ route('crearActividad') }}" type="button" class="btn btn-warning"><i
                                    class="fas fa-plus-circle"></i> Nueva</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div style="display: none">{{ $cont = 0 }}</div>
                        @if (count($actividades) > 0)
                            <table class="table table-bordered">
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
                                            <td>{{ $actividad->idLugar->nombreLugar }}
                                                ({{ $actividad->idLugar->aulaLugar }})
                                            </td>
                                            <td>
                                                <center>
                                                    <div class="btn-group">
                                                        <center><a
                                                                href="{{ route('fecha', ['id' => $actividad->idActividad]) }}"
                                                                class="btn btn-warning"><i class="fas fa-search"></i></a>
                                                    </div>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <div class="btn-group">
                                                        <center><a
                                                                href="{{ route('recurso', ['id' => $actividad->idActividad]) }}"
                                                                class="btn btn-warning"><i class="fas fa-search"></i></a>
                                                    </div>
                                                </center>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('editarActividad', $actividad->idActividad) }}"
                                                        class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                                    <a class="btn btn-danger borrarActividad" style="cursor: pointer;">
                                                        <p class="idActividad" hidden>{{ $actividad->idActividad }}
                                                        </p>
                                                        <p class="nombreActividad" hidden>
                                                            {{ $actividad->nombreActividad }}
                                                        </p>
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                        @if (count($actividades) == 0)
                            <h5>
                                <center>No existen actividades registradas</center>
                            </h5>
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
