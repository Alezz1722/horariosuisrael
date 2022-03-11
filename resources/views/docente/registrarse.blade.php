@extends('plantilla')

@section('contenidoPrincipal')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-plus-circle"></i> Registro de nuevo docente</span>
                    </div>
                    <div class="card-body">
                        @if (session()->has('success'))
                            <div class="alert alert-warning">
                                <i class="bi bi-check-square"></i> {{ session()->get('success') }}
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger">
                                <i class="bi bi-x-square"></i> {{ session()->get('error') }}
                            </div>
                        @endif
                        <form id="formNuevoDocente" method="POST" action="{{ route('nuevoUsuario') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="nombreUsuario" class="col-sm-3 col-form-label">Nombre</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario"
                                        placeholder="Ingrese el nombre del docente" value="{{ old('nombreUsuario') }}"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="apellidoUsuario" class="col-sm-3 col-form-label">Apellido</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="apellidoUsuario" name="apellidoUsuario"
                                        placeholder="Ingrese el apellido del docente" value="{{ old('apellidoUsuario') }}"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="correoUsuario" class="col-sm-3 col-form-label">Correo</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="correoUsuario" name="correoUsuario"
                                        placeholder="Ingrese el correo del docente" value="{{ old('correoUsuario') }}"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="contrasenaUsuario" class="col-sm-3 col-form-label">Contraseña</label>
                                <div class="col-sm-9">
                                    <span id="btnClave" toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password" onclick="javascript: password = document.getElementById('contrasenaUsuario'); btnClave = document.getElementById('btnClave'); if (password.type == 'password') { password.type = 'text'; btnClave.classList.remove('fa-eye'); btnClave.classList.add('fa-eye-slash'); } else { password.type = 'password'; btnClave.classList.remove('fa-eye-slash'); btnClave.classList.add('fa-eye'); }"></span>
                                    <input type="password" class="form-control" id="contrasenaUsuario"
                                        name="contrasenaUsuario" placeholder="Ingrese la contraseña del docente"
                                        value="{{ old('contrasenaUsuario') }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="confContrasenaUsuario" class="col-sm-3 col-form-label">Confirmación
                                    contraseña</label>
                                <div class="col-sm-9">
                                    <span id="btnConfirmaClave" toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password" onclick="javascript: password = document.getElementById('confContrasenaUsuario'); btnClave = document.getElementById('btnConfirmaClave'); if (password.type == 'password') { password.type = 'text'; btnClave.classList.remove('fa-eye'); btnClave.classList.add('fa-eye-slash'); } else { password.type = 'password'; btnClave.classList.remove('fa-eye-slash'); btnClave.classList.add('fa-eye'); }"></span>
                                    <input type="password" class="form-control" id="confContrasenaUsuario"
                                        name="confContrasenaUsuario" placeholder="Repita la contraseña del docente"
                                        value="{{ old('confContrasenaUsuario') }}" required>
                                </div>
                            </div>
                            <button class="btn btn-warning btn-block" type="submit" id="submitFormPeriodo"><i
                                    class="fas fa-plus"></i> Registrar docente</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('js/docente/validadocente.js') }}"></script>
@endsection
