@extends('plantilla')

@section('contenidoPrincipal')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-clipboard-list"></i> Recursos establecidos para la actividad
                            "{{ $actividad->nombreActividad }}" de {{ session('usuarioConectado')['nombreUsuario'] }}
                            {{ session('usuarioConectado')['apellidoUsuario'] }} </span>
                        <input type="text" class="form-control" id="idActividad" name="idActividad"
                            value="{{ $actividad->idActividad }}" hidden>
                        <a href="{{ route('crearRecurso', ['id' => $actividad->idActividad]) }}"
                            class="btn btn-warning btn-sm"><i class="fas fa-plus-circle"></i> Nuevo Recurso</a>
                    </div>
                    <div class="card-body">
                        <div style="display: none">{{ $cont = 0 }}</div>
                        @if (count($recursos) > 0)
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Url</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recursos as $recurso)
                                        <tr>
                                            <th scope="row">{{ ++$cont }}</th>
                                            <td>{{ $recurso->nombreRecurso }}</td>
                                            <td><a target="_blank"
                                                    href="{{ $recurso->urlRecurso }}">{{ $recurso->urlRecurso }}</a>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('editarRecurso', $recurso->idRecurso) }}"
                                                        class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                                    <a class="btn btn-danger borrarRecurso">
                                                        <p class="idRecurso" hidden>{{ $recurso->idRecurso }}</p>
                                                        <p class="nombreRecurso" hidden>{{ $recurso->nombreRecurso }}
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
                        @if (count($recursos) == 0)
                            <h5>
                                <center>No existen recursos registrados</center>
                            </h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/recurso/lstRecurso.js') }}"></script>
@endsection
