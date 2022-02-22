@extends('plantilla')

@section('contenidoPrincipal')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-plus-circle"></i> Agregar Horario</span>
                    <a href="{{ route('fecha', [ 'id' => $actividad->idActividad]) }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-circle-left"></i> Regresar a lista de horarios</a>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <i class="fas fa-exclamation-triangle"></i> Por favor corrige los siguientes errores :
                        <ul class="listaErrores">
                        </ul>
                    </div>
                    <div class="card text-center" >
                        <div class="card-body">
                          <p class="card-title"> {{ $actividad->nombreActividad }}</p>
                          <p class="card-text text-muted">{{$periodo->nombrePeriodo}} ( De <b class="fechaInicioPeriodo">{{ $periodo->fechaInicioPeriodo }}</b> hasta <b class="fechaFinPeriodo">{{ $periodo->fechaFinPeriodo }}</b>)</b>
                        </div>
                    </div>
                    <br>
                  <form id="formFecha" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="frecuenciaFecha" class="col-sm-3 col-form-label">Frecuencia</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="frecuenciaFecha" id="frecuenciaFecha">
                                <option value="">Seleccione la frecuencia</option>
                                <option value="frecuenciaUnaVez">Una sola vez</option>
                                <option value="frecuenciaUnaVezSemana">Una vez a la semana</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="fechaInicioDiv" >
                        <label for="fechaInicioFecha" class="col-sm-3 col-form-label">Fecha inicio</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="fechaInicioFecha" name="fechaInicioFecha" placeholder="Establezca la fecha inicio del horario" onkeydown="event.preventDefault()" autocomplete="off" value="" disabled>
                        </div>
                    </div>
                    <div class="form-group row" id="fechaFinDiv" >
                        <label for="fechaFinFecha" class="col-sm-3 col-form-label">Fecha fin</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="fechaFinFecha" name="fechaFinFecha" placeholder="Establezca la fecha fin del horario" onkeydown="event.preventDefault()" autocomplete="off" value="" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="diaFecha" class="col-sm-3 col-form-label">Dia</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="diaFecha" id="diaFecha" disabled>
                                <option value="">Establezca el día inicio ..</option>
                                <option value="lunes">Lunes</option>
                                <option value="martes">Martes</option>
                                <option value="miercoles">Miercoles</option>
                                <option value="jueves">Jueves</option>
                                <option value="viernes">Viernes</option>
                                <option value="sabado">Sábado</option>
                                <option value="domingo">Domingo</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="horaInicioFecha" class="col-sm-3 col-form-label">Hora inicio</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="horaInicioFecha" name="horaInicioFecha" placeholder="Ingrese la hora inicial del horario" onkeydown="event.preventDefault()" value="{{ old('horaInicioFecha') }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="horaFinFecha" class="col-sm-3 col-form-label">Hora fin</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="horaFinFecha" name="horaFinFecha" placeholder="Ingrese la hora fin del horario" onkeydown="event.preventDefault()" value="{{ old('horaFinFecha') }}" disabled>
                        </div>
                    </div>
                    <input type="text" class="form-control" id="idActividad" name="idActividad" value="{{ $actividad->idActividad }}" hidden>
                    <button class="btn btn-primary btn-block" type="submit" id="submitFormFecha"><i class="fas fa-plus"></i> Agregar horario</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/fecha/fechajs.js') }}"></script>
@endsection

