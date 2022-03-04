@extends('plantilla')


@section('contenidoPrincipal')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="idActividad" style="display: none">{{ $actividad->idActividad }}</div>
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-edit"></i> Editar Actividad</span>
                        <a href="{{ route('actividad') }}" class="btn btn-warning btn-sm"><i
                                class="fas fa-arrow-circle-left"></i> Regresar a lista de actividades</a>
                    </div>
                    <div class="card-body">
                        @if (session('mensaje'))
                            <div class="alert alert-success">{{ session('mensaje') }}</div>
                        @endif
                        <form id="formEditaActividad" method="POST">
                            @csrf
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                                <i class="fas fa-exclamation-triangle"></i> Por favor corrige los siguientes errores :
                                <ul class="listaErrores">
                                </ul>
                            </div>
                            <div class="form-group row">
                                <label for="nombreActividad" class="col-sm-2 col-form-label">Nombre</label>
                                <div class="col-sm-10">
                                    <div class="nombreActividad" hidden>{{ $actividad->nombreActividad }}</div>
                                    <input type="text" class="form-control" id="nombreActividad" name="nombreActividad"
                                        placeholder="Ingrese el nombre de la actividad"
                                        value="{{ $actividad->nombreActividad }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="descripcionActividad" class="col-sm-2 col-form-label">Descripcion</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="descripcionActividad"
                                        name="descripcionActividad" placeholder="Ingrese la descripcion de la actividad"
                                        value="{{ $actividad->descripcionActividad }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="idPeriodo" class="col-sm-2 col-form-label">Periodo</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="idPeriodo">
                                        <option value="">Seleccione el periodo</option>
                                        @foreach ($periodos as $key => $value)
                                            <option value="{{ $value->idPeriodo }}"
                                                {{ $value->idPeriodo == $actividad->idPeriodo ? 'selected' : '' }}>
                                                {{ $value->nombrePeriodo }}
                                                ({{ $value->fechaInicioPeriodo }}/{{ $value->fechaFinPeriodo }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="idLugar" class="col-sm-2 col-form-label">Lugar</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="idLugar">
                                        <option value="">Seleccione el lugar</option>
                                        @foreach ($lugares as $key => $value)
                                            <option value="{{ $value->idLugar }}"
                                                {{ $value->idLugar == $actividad->idLugar ? 'selected' : '' }}>
                                                {{ $value->nombreLugar }} ({{ $value->direccionLugar }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-warning btn-block" type="submit"><i class="far fa-edit"></i> Editar
                                lugar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/actividad/actividadUpdatejs.js') }}"></script>
@endsection
