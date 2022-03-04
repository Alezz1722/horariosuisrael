@extends('plantilla')

@section('contenidoPrincipal')

<div class="container">
    <div class="row justify-content-center mb-5">
        <div class="col-md-12">
            <center><h5 class="mt-4" style="color: #F5F5F5; font-weight: 700;">Importar Actividades a través de un documento Excel</h5></center>
            <br>
            <p class="alert alert-info">* Considerar que los horarios a registrar se registrarán en horarios de una vez a la semana por todo el periodo establecido.</p>
        </div>
        <div class="col-md-9">
            <h6>Seleccione un archivo excel para importar :</h6>
        </div>
        <div class="col-md-3">
            <a href="#" class="btn btn-success btn-block" data-toggle="modal" data-target="#importaExcel"><i class="bi bi-file-earmark-excel"></i> Formato requerido</a>
        </div>
        <div class="col-md-12">
            <br>
            <input style="padding:3px;" class="form-control" type="file" id="inputImportaExcel" data-buttonText="Seleccionar archivo.." data-buttonName="btn-primary" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required >
        </div>
        <div class="col-md-6">
            <br>
            <form id="formPeriodo" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="idPeriodo" class="col-sm-2 col-form-label">Periodo</label>
                    <div class="col-sm-10">
                        <select class="form-control idPeriodo" name="idPeriodo">
                            <option value="">Seleccione el periodo</option>
                            @foreach ($periodos as $key => $value)
                                <option value="{{ $value->idPeriodo }}">
                                    {{ $value->nombrePeriodo }} ({{ $value->fechaInicioPeriodo }} / {{ $value->fechaFinPeriodo }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <br>
            <button class="btn btn-dark btn-block" id="submitFormPeriodo"><i class="bi bi-file-earmark-excel-fill"></i> Leer Excel</button>
        </div>
        <div class="col-md-12 conjuntoExcel" hidden>
            <table class="table tablaExcel table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">DIA</th>
                    <th scope="col">HORA</th>
                    <th scope="col">MATERIA</th>
                    <th scope="col">AULA</th>
                    <th scope="col">LUGAR</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
        </div>
        <div class="col-md-12 conjuntoExcel" hidden>
            <button class="btn btn-success btn-block " id="enviaData"><i class="bi bi-file-earmark-excel-fill"></i> Importar documento Excel</button>
        </div>
    </div>
    <div class="modal fade" id="importaExcel" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header d-block" style="text-align: center;">
                <div class="d-flex">
                    <h5 class='col-12 modal-title text-center'>
                        <i class="bi bi-file-earmark-excel"></i> Formato para importar actividades
                    </h5>
                </div>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="text-center">
                        <img src="{{ asset('ejemplos/imgEjmActividad.jpg') }}" class="img-fluid" alt="...">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-success" href="{{ asset('ejemplos/Ejm_actividad.xlsx') }}" role="button"><i class="bi bi-file-earmark-arrow-down"></i> Descargar formato</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times-circle"></i> Cerrar</button>
            </div>
          </div>
        </div>
    </div>
</div>
@section('scripts')
<script src="{{ asset('js/docente/importaActividades.js') }}"></script>
@endsection
