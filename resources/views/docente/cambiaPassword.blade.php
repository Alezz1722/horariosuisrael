@extends('plantilla')

@section('contenidoPrincipal')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h5 class="text-center mt-3">Cambio de contraseña</h5>
            </div>
            <div class="col-md-6 caja px-5 py-4 mt-3 mb-5">
                <br>
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
                <form id="formCambioContrasenaDocente" method="POST" action="{{ route('passwordDocente') }}">
                    @csrf
                    <div class="form-row">
                        <div class="col-12 mb-4">
                            <label for="password">Contraseña actual <span class="spansito">*</span></label>
                            <div class="col-sm-12">
                                <span id="btnClave" toggle="#password-field"
                                    class="fa fa-fw fa-eye field-icon toggle-password"
                                    onclick="javascript: password = document.getElementById('contrasenaActualDocente'); btnClave = document.getElementById('btnClave'); if (password.type == 'password') { password.type = 'text'; btnClave.classList.remove('fa-eye'); btnClave.classList.add('fa-eye-slash'); } else { password.type = 'password'; btnClave.classList.remove('fa-eye-slash'); btnClave.classList.add('fa-eye'); }"></span>
                                <input type="password" class="form-control" id="contrasenaActualDocente"
                                    name="contrasenaActualDocente" placeholder="">
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <label for="password">Nueva contraseña <span class="spansito">*</span></label>
                            <div class="col-sm-12">
                                <span id="btnNuevaClave" toggle="#password-field"
                                    class="fa fa-fw fa-eye field-icon toggle-password"
                                    onclick="javascript: password = document.getElementById('nuevaContrasenaDocente'); btnClave = document.getElementById('btnNuevaClave'); if (password.type == 'password') { password.type = 'text'; btnClave.classList.remove('fa-eye'); btnClave.classList.add('fa-eye-slash'); } else { password.type = 'password'; btnClave.classList.remove('fa-eye-slash'); btnClave.classList.add('fa-eye'); }"></span>
                                <input type="password" class="form-control" id="nuevaContrasenaDocente"
                                    name="nuevaContrasenaDocente" placeholder="">
                            </div>
                        </div>
                        <div class="col-12 my-2">
                            <label for="password">Confirmación nueva contraseña <span
                                    class="spansito">*</span></label>
                            <div class="col-sm-12">
                                <span id="btnConfirmaNuevaClave" toggle="#password-field"
                                    class="fa fa-fw fa-eye field-icon toggle-password"
                                    onclick="javascript: password = document.getElementById('confirmaNuevaContrasenaDocente'); btnClave = document.getElementById('btnConfirmaNuevaClave'); if (password.type == 'password') { password.type = 'text'; btnClave.classList.remove('fa-eye'); btnClave.classList.add('fa-eye-slash'); } else { password.type = 'password'; btnClave.classList.remove('fa-eye-slash'); btnClave.classList.add('fa-eye'); }"></span>
                                <input type="password" class="form-control" id="confirmaNuevaContrasenaDocente"
                                    name="confirmaNuevaContrasenaDocente" placeholder="">
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
@endsection
