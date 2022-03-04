@extends('plantilla')

@section('contenidoPrincipal')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-clipboard-list"></i> Lista de lugares para
                            {{ session('usuarioConectado')['nombreUsuario'] }}
                            {{ session('usuarioConectado')['apellidoUsuario'] }} </span>
                        <a href="{{ route('crearLugar') }}" class="btn btn-primary btn-sm"><i
                                class="fas fa-plus-circle"></i> Nuevo Lugar</a>
                    </div>
                    <div class="card-body">
                        <div style="display: none">{{ $cont = 0 }}</div>
                        @if (count($lugares) > 0)
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Direccion</th>
                                        <th scope="col">Aula</th>
                                        <th scope="col">Teléfono</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lugares as $lugar)
                                        <tr>
                                            <th scope="row">{{ ++$cont }}</th>
                                            <td>{{ $lugar->nombreLugar }}</td>
                                            <td>{{ $lugar->direccionLugar }}</td>
                                            <td>{{ $lugar->aulaLugar }}</td>
                                            <td>{{ $lugar->telefonoLugar }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('editarLugar', $lugar->idLugar) }}"
                                                        class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                                    <a class="btn btn-danger borrarLugar">
                                                        <p class="idLugar" hidden>{{ $lugar->idLugar }}</p>
                                                        <p class="nombreLugar" hidden>{{ $lugar->nombreLugar }}</p>
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                        @if (count($lugares) == 0)
                            <h5>
                                <center>No existen lugares registrados</center>
                            </h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/lugar/lstLugar.js') }}"></script>
@endsection
