@extends('plantilla')
@section('csss')
    <link href="{{ asset('css/docente/docente.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('contenidoPrincipal')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-2">
                        <b>Profesor:</b>
                    </div>
                    <div class="col-md-10">
                        <select class="form-control" name="profesorSelect" id="profesorSelect">
                            <option value="">Establezca el profesor ..</option>
                            @foreach ($docentes as $docente)
                                <option value="{{ $docente->idUsuario }}">{{ $docente->nombreUsuario }}
                                    {{ $docente->apellidoUsuario }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <b>Semana:</b>
                    </div>
                    <div class="col-md-10">
                        <input type='text' class="form-control" id='semanaDatePicker' placeholder="Selecciona la semana"
                            onkeydown="event.preventDefault()" />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-12">
                    <br>
                    <div class="btn-group d-flex" role="group" aria-label="Basic example">
                        <a style="cursor: default;color: white;font-weight: bold;" type="button"
                            class="btn btn-success w-100"><i class="bi bi-check-circle"></i> Activas</a>
                        <a style="cursor: default;color: black;font-weight: bold;" type="button"
                            class="btn btn-warning w-100"><i class="bi bi-arrow-up-right-circle"></i> Aplazadas</a>
                        <a style="cursor: default;color: white;font-weight: bold;" type="button"
                            class="btn btn-dark w-100"><i class="bi bi-x-circle"></i> Canceladas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container-fluid">
        <div class="row" style="margin: auto;">
            <table class="table table-bordered table-striped" id="dashboardDocente">
                <thead class="thead-dark">
                    <tr></tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header d-block modalHeader" style="text-align: center;">
                    <i class="bi bi-person-video3"></i>
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
                            <div class="col-md-3" style="text-align: end;"><b>Estado</b></div>
                            <div class="col-md-9 modalEstado"></div>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times-circle"></i>
                        Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="notificacion"></div>
@endsection

@section('scripts')
    <script src="{{ asset('js/docente/docenteIndexjs.js') }}"></script>
@endsection
