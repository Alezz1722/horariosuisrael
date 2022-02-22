@extends('plantilla')

@section('contenidoPrincipal')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-plus-circle"></i> Agregar Lugar</span>
                    <a href="{{ route('lugar') }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-circle-left"></i> Regresar a lista de lugares</a>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <i class="fas fa-exclamation-triangle"></i> Por favor corrige los siguientes errores :
                        <ul class="listaErrores">
                        </ul>
                    </div>
                  <form id="formLugar" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="nombreLugar" class="col-sm-2 col-form-label">Nombre</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nombreLugar" name="nombreLugar" placeholder="Ingrese el nombre del lugar" value="{{ old('nombreLugar') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="direccionLugar" class="col-sm-2 col-form-label">Dirección</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="direccionLugar" name="direccionLugar" placeholder="Ingrese la dirección del lugar" value="{{ old('direccionLugar') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="direccionLugar" class="col-sm-2 col-form-label">Aula</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="aulaLugar" name="aulaLugar" placeholder="Ingrese el aula del lugar" value="{{ old('aulaLugar') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="telefonoLugar" class="col-sm-2 col-form-label">Teléfono</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="telefonoLugar" name="telefonoLugar" placeholder="Ingrese el teléfono del lugar" value="{{ old('telefonoLugar') }}">
                        </div>
                    </div>

                    <button class="btn btn-primary btn-block" type="submit" id="submitFormPeriodo"><i class="fas fa-plus"></i> Agregar lugar</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/lugar/lugarjs.js') }}"></script>
@endsection

