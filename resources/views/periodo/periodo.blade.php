@extends('plantilla')

@section('contenidoPrincipal')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-clipboard-list"></i> Lista de periodos para {{ session('usuarioConectado')['nombreUsuario'] }} {{ session('usuarioConectado')['apellidoUsuario'] }} </span>
                    <a href="{{ route('crearPeriodo') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle"></i> Nuevo Periodo</a>
                </div>
                <div class="card-body">
                    <div style="display: none">{{ $cont =0 }}</div>
                    @if (count($periodos) > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Fecha inicio</th>
                                <th scope="col">Fecha fin</th>
                                <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($periodos as $periodo)
                                <tr>
                                    <th scope="row">{{ ++$cont }}</th>
                                    <td>{{ $periodo->nombrePeriodo }}</td>
                                    <td>{{ $periodo->descripcionPeriodo }}</td>
                                    <td>{{ $periodo->fechaInicioPeriodo }}</td>
                                    <td>{{ $periodo->fechaFinPeriodo }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{route('editarPeriodo', $periodo->idPeriodo)}}" class="btn btn-warning">Editar</a>
                                            <a class="btn btn-danger borrarPeriodo">
                                                <p class="idPeriodo" hidden>{{$periodo->idPeriodo}}</p>
                                                <p class="nombrePeriodo" hidden>{{$periodo->nombrePeriodo}}</p>
                                                Borrar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    @if (count($periodos) == 0)
                        <h5><center>No existen periodos registrados</center></h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/periodo/lstPeriodo.js') }}"></script>
@endsection
