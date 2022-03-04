@extends('plantilla')

@section('contenidoPrincipal')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-plus-circle"></i> Agregar Periodo</span>
                        <a href="{{ route('periodo') }}" class="btn btn-warning btn-sm"><i
                                class="fas fa-arrow-circle-left"></i> Regresar a lista de periodos</a>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                            <i class="fas fa-exclamation-triangle"></i> Por favor corrige los siguientes errores :
                            <ul class="listaErrores">
                            </ul>
                        </div>
                        <form id="formPeriodo" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="nombrePeriodo" class="col-sm-2 col-form-label">Nombre</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nombrePeriodo" name="nombrePeriodo"
                                        placeholder="Ingrese el nombre del periodo" value="{{ old('nombrePeriodo') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="descripcionPeriodo" class="col-sm-2 col-form-label">Descripcion</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="descripcionPeriodo"
                                        name="descripcionPeriodo" placeholder="Ingrese la descripcion del periodo"
                                        value="{{ old('descripcionPeriodo') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nombrePeriodo" class="col-sm-2 col-form-label">Fecha inicio</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="fechaInicioPeriodo"
                                        name="fechaInicioPeriodo" placeholder="Establezca la fecha inicio del periodo"
                                        onkeydown="event.preventDefault()" value="{{ old('fechaInicioPeriodo') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fechaFinPeriodo" class="col-sm-2 col-form-label">Fecha fin</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="fechaFinPeriodo" name="fechaFinPeriodo"
                                        placeholder="Establezca la fecha fin del periodo" onkeydown="event.preventDefault()"
                                        value="{{ old('fechaInicioPeriodo') }}">
                                </div>
                            </div>
                            <button class="btn btn-warning btn-block" type="submit" id="submitFormPeriodo"><i
                                    class="fas fa-plus"></i> Agregar periodo</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/periodo/periodojs.js') }}"></script>
@endsection
