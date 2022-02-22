@extends('plantilla')


@section('contenidoPrincipal')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="idPeriodo" style="display: none">{{ $periodo->idPeriodo }}</div>
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-edit"></i> Editar Periodo</span>
                    <a href="{{ route('periodo') }}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-circle-left"></i> Regresar a lista de periodos</a>
                </div>
                <div class="card-body">
                  @if ( session('mensaje') )
                    <div class="alert alert-success">{{ session('mensaje') }}</div>
                  @endif
                  <form id="formEditaPeriodo" method="POST">
                    @csrf
                    @if ($errors->any())
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> Por favor corrige los siguientes errores :
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    @endif
                    <div class="form-group row">
                        <label for="nombrePeriodo" class="col-sm-2 col-form-label">Nombre</label>
                        <div class="col-sm-10">
                            <div class="nombrePeriodo" hidden>{{ $periodo->nombrePeriodo }}</div>
                            <input type="text" class="form-control" id="nombrePeriodo" name="nombrePeriodo" placeholder="Ingrese el nombre del periodo" value="{{ $periodo->nombrePeriodo }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="descripcionPeriodo" class="col-sm-2 col-form-label">Descripcion</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="descripcionPeriodo" name="descripcionPeriodo" placeholder="Ingrese la descripcion del periodo" value="{{ $periodo->descripcionPeriodo }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nombrePeriodo" class="col-sm-2 col-form-label">Fecha inicio</label>
                        <div class="col-sm-10">
                            <div id="fip" style="display: none">{{ $periodo->fechaInicioPeriodo }}</div>
                            <input type="text" class="form-control" id="fechaInicioPeriodo" name="fechaInicioPeriodo" placeholder="Establezca la fecha inicio del periodo" onkeydown="event.preventDefault()" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="fechaFinPeriodo" class="col-sm-2 col-form-label">Fecha fin</label>
                        <div class="col-sm-10">
                            <div id="ffp" style="display: none">{{ $periodo->fechaFinPeriodo }}</div>
                            <input type="text" class="form-control" id="fechaFinPeriodo" name="fechaFinPeriodo" placeholder="Establezca la fecha fin del periodo" onkeydown="event.preventDefault()" value="">
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block" type="submit"><i class="far fa-edit"></i> Editar periodo</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/periodo/periodoUpdatejs.js') }}"></script>
@endsection

