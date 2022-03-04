@extends('plantilla')

@section('contenidoPrincipal')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-edit"></i> Editar Recurso</span>
                        <a href="{{ route('recurso', ['id' => $recurso->idActividad->idActividad]) }}"
                            class="btn btn-warning btn-sm"><i class="fas fa-arrow-circle-left"></i> Regresar a lista de
                            recursos</a>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                            <i class="fas fa-exclamation-triangle"></i> Por favor corrige los siguientes errores :
                            <ul class="listaErrores">
                            </ul>
                        </div>
                        <div class="card text-center">
                            <div class="card-body">
                                <p class="card-title"> {{ $recurso->idActividad->nombreActividad }}</p>
                                <p class="card-text text-muted">{{ $recurso->idActividad->idPeriodo->nombrePeriodo }} ( De
                                    <b
                                        class="fechaInicioPeriodo">{{ $recurso->idActividad->idPeriodo->fechaInicioPeriodo }}</b>
                                    hasta <b
                                        class="fechaFinPeriodo">{{ $recurso->idActividad->idPeriodo->fechaFinPeriodo }}</b>)</b>
                                <div id="idRecurso" style="display: none">{{ $recurso->idRecurso }}</div>
                            </div>
                        </div>
                        <br>
                        <form id="formRecurso" method="POST">
                            @csrf
                            <div class="form-group row" id="nombreRecurso">
                                <label for="nombreRecurso" class="col-sm-3 col-form-label">Nombre recurso</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control nombreRecurso" id="nombreRecurso"
                                        name="nombreRecurso" placeholder="Establezca el nombre del recurso"
                                        autocomplete="off" value="{{ $recurso->nombreRecurso }}">
                                </div>
                            </div>
                            <div class="form-group row" id="urlRecurso">
                                <label for="urlRecurso" class="col-sm-3 col-form-label">Url Recurso</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control urlRecurso" id="urlRecurso" name="urlRecurso"
                                        placeholder="Establezca la url del recurso" autocomplete="off"
                                        value="{{ $recurso->urlRecurso }}">
                                </div>
                            </div>
                            <input type="text" class="form-control" id="idActividad" name="idActividad"
                                value="{{ $recurso->idActividad->idActividad }}" hidden>
                            <button class="btn btn-warning btn-block" type="submit" id="submitFormRecurso"><i
                                    class="fas fa-edit"></i> Editar recurso</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/recurso/recursoUpdatejs.js') }}"></script>
@endsection
