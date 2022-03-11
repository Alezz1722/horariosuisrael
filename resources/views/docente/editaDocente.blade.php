@extends('plantilla')

@section('contenidoPrincipal')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h5 class="text-center mt-3">Perfil de {{ $usuario->nombreUsuario }}
                    {{ $usuario->apellidoUsuario }}</h5>
            </div>
            <div class="col-md-6 caja px-5 py-5 mt-3 mb-5">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        <i class="bi bi-check-square"></i> {{ session()->get('success') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        <i class="bi bi-x-square"></i> {{ session()->get('error') }}
                    </div>
                @endif
                <form name="formUsuario" id="formUsuario" method="post" action="">
                    @csrf
                    <div class="form-row">
                        <div class="col-6 mb-2">
                            <label for="nombreUsuario">Nombre <span
                                    class="spansito">*</span></label>
                            <input type="text" id="nombreUsuario" name="nombreUsuario"
                                placeholder="Ingrese el nombre" class="form-control"
                                value="{{ $usuario->nombreUsuario }}">
                        </div>
                        <div class="col-6 mb-2">
                            <label for="apellidoUsuario">Apellido <span
                                    class="spansito">*</span></label>
                            <input type="text" id="apellidoUsuario" name="apellidoUsuario"
                                placeholder="Ingrese el apellido" class="form-control"
                                value="{{ $usuario->apellidoUsuario }}">
                        </div>
                        <div class="col-12 mb-2">
                            <label for="correoUsuario">E-mail <span class="spansito">*</span></label>
                            <input type="text" id="correoUsuario" name="correoUsuario"
                                placeholder="Ingrese el correo electronico del docente" class="form-control"
                                value="{{ $usuario->correoUsuario }}">
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-warning btn-block"><i class="bi bi-pencil-square"></i>
                                Editar mi usuario</button>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>

@section('scripts')
    <script src="{{ asset('js/docente/validadocente.js') }}"></script>
@endsection
