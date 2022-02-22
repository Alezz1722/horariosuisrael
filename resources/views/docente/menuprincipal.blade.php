@extends('plantilla')
@section('csss')
<link href="{{ asset('css/docente/docente.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('contenidoPrincipal')


<div class="container">
    <div class="row">
        <div class="offset-md-3 col-md-6">
            <div class="row">
                <div class="col-md-2">
                    Semana
                </div>
                <div class="col-md-10">
                    <input type='text' class="form-control" id='semanaDatePicker' placeholder="Selecciona la semana" onkeydown="event.preventDefault()"/>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="container">
    <table class="table table-bordered w-100" id="dashboardDocente">
        <thead><tr></tr></thead>
        <tbody></tbody>
    </table>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header d-block" style="text-align: center;">
            <div class="d-flex">
                <h3 class='col-12 modal-title text-center'>
                    Modal Title
                </h3>
            </div>
            <h6 class="modal-subtitle1"></h6>
            <h6 class="modal-subtitle2"></h6>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <form id="formFecha" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-3" style="text-align: end;"><b>Estado</b></div>
                        <div class="col-md-9">
                            <select class="form-control" name="estadoActividad" id="estadoActividad">
                                <option value="">Seleccione la frecuencia</option>
                                <option value="ACTIVA">ACTIVA</option>
                                <option value="APLAZADA">APLAZADA</option>
                                <option value="CANCELADA">CANCELADA</option>
                            </select>
                        </div>
                    </div>
                    <br class="brForm" hidden>
                    <div class="row fechaForm" hidden>
                        <div class="col-md-3" style="text-align: end;"><b>Fecha</b></div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="fechaInicio" name="fechaInicio" placeholder="Establezca la fecha" onkeydown="event.preventDefault()" autocomplete="off" value="" >
                        </div>
                    </div>
                    <br class="brForm" hidden>
                    <div class="row inicioForm" hidden>
                        <div class="col-md-3" style="text-align: end;"><b>H.inicio</b></div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="horaInicio" name="horaInicio" placeholder="Establezca la hora inicio" onkeydown="event.preventDefault()" autocomplete="off" value="" >
                        </div>
                    </div>
                    <br class="brForm" hidden>
                    <div class="row finForm" hidden>
                        <div class="col-md-3" style="text-align: end;"><b>H.fin</b></div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="horaFin" name="horaFin" placeholder="Establezca la hora fin" onkeydown="event.preventDefault()" autocomplete="off" value="" >
                        </div>
                    </div>
                    <br class="brFormCancelado" hidden>
                    <div class="row observacionForm" hidden>
                        <div class="col-md-3" style="text-align: end;"><b>Observación</b></div>
                        <div class="col-md-9">
                            <textarea class="md-textarea form-control observacion" rows="2" id="observacion" name="observacion"></textarea>
                        </div>
                    </div>
                    <br>
                    <button class="btn btn-primary btn-block" type="submit" id="submitFormFecha" hidden><i class="fas fa-edit"></i> Establecer estado de horario</button>
                </form>
                <hr>
                <div class="row">
                  <div class="col-md-3" style="text-align: end;"><b>Descripción</b></div>
                  <div class="col-md-9 modalActividad"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3" style="text-align: end;"><b>Frecuencia</b></div>
                    <div class="col-md-9 modalFrecuencia"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3" style="text-align: end;"><b>Periodo</b></div>
                    <div class="col-md-9 modalPeriodo"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3" style="text-align: end;"><b>Recursos</b></div>
                    <div class="col-md-9 modalRecursos"></div>
                </div>
                <hr>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times-circle"></i> Cerrar</button>
        </div>
      </div>
    </div>
</div>

<div class="notificacion"></div>
@endsection

@section('scripts')
<script src="{{ asset('js/docente/docentejs.js') }}"></script>
<script src="{{ asset('js/docente/importaActividades.js') }}"></script>
@endsection
