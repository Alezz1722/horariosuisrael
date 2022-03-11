@extends('plantilla')

@section('contenidoPrincipal')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 caja px-5 py-4 mt-3 mb-5">
                <center>
                    <h5><i class="bi bi-exclamation-circle"></i> Cambio de contraseña</h5>
                    <br>
                    <p>Hola {{ $usuario->nombreUsuario }} {{ $usuario->apellidoUsuario }}<br>Por favor, llena el
                        formulario para cambiar su contraseña</p>
                    <div id="codigoEmprendedor" style="display: none">{{ $usuario->codigoUsuario }}</div>
                </center>
            </div>
            <div class="col-12 col-md-8 caja px-5 py-4 mt-3 mb-5">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif
                <form id="formCambioContrasena" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="col-12 mb-2">
                            <label for="password">Contraseña <span class="spansito">*</span></label>
                            <div class="col-sm-12">
                                <span id="btnClave" toggle="#password-field"
                                    class="fa fa-fw fa-eye field-icon toggle-password"
                                    onclick="javascript: password = document.getElementById('contrasenaUsuario'); btnClave = document.getElementById('btnClave'); if (password.type == 'password') { password.type = 'text'; btnClave.classList.remove('fa-eye'); btnClave.classList.add('fa-eye-slash'); } else { password.type = 'password'; btnClave.classList.remove('fa-eye-slash'); btnClave.classList.add('fa-eye'); }"></span>
                                <input type="password" class="form-control" id="contrasenaUsuario"
                                    name="contrasenaUsuario" placeholder="">
                            </div>

                        </div>
                        <div class="col-12 my-2">
                            <label for="password">Confirmación Contraseña <span class="spansito">*</span></label>
                            <div class="col-sm-12">
                                <span id="btnClave" toggle="#password-field"
                                    class="fa fa-fw fa-eye field-icon toggle-password"
                                    onclick="javascript: password = document.getElementById('confirmaContrasenaUsuario'); btnClave = document.getElementById('btnClave'); if (password.type == 'password') { password.type = 'text'; btnClave.classList.remove('fa-eye'); btnClave.classList.add('fa-eye-slash'); } else { password.type = 'password'; btnClave.classList.remove('fa-eye-slash'); btnClave.classList.add('fa-eye'); }"></span>
                                <input type="password" class="form-control" id="confirmaContrasenaUsuario"
                                    name="confirmaContrasenaUsuario" placeholder="">
                            </div>

                        </div>
                        <div class="col-12 mt-4">
                            <center><button class="btn btn-warning btn-block" type="submit"
                                    id="submitFormCambioContrasena"><i class="bi bi-pencil-square"></i> Cambiar
                                    contraseña</button></center>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/login/validacionCambioContrasena.js') }}"></script>
    <script src="{{ asset('js/login/cambioContrasena.js') }}"></script>
@endsection
