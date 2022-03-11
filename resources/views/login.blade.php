@extends('plantilla')

@section('contenidoPrincipal')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('mensaje'))
                <div class="alert alert-success">
                    {{ session('mensaje') }}
                </div>
            @endif
            @if (session('mensajeError'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> Alerta - {{ session('mensajeError') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header"><i class="fas fa-chalkboard-teacher"></i> Login de Docentes</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Correo Electrónico</label>

                            <div class="col-md-6">
                                <input id="correo" type="email" placeholder="Ingrese el correo electrónico del docente"
                                    class="form-control @error('correo') is-invalid @enderror" name="correo"
                                    value="{{ old('correo') }}" required autocomplete="correo" autofocus>

                                @error('correo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña</label>

                            <div class="col-md-6">
                                <span id="btnClave" toggle="#password-field"
                                    class="fa fa-fw fa-eye field-icon toggle-password"
                                    onclick="javascript: password = document.getElementById('contrasena'); btnClave = document.getElementById('btnClave'); if (password.type == 'password') { password.type = 'text'; btnClave.classList.remove('fa-eye'); btnClave.classList.add('fa-eye-slash'); } else { password.type = 'password'; btnClave.classList.remove('fa-eye-slash'); btnClave.classList.add('fa-eye'); }"></span>
                                <input id="contrasena" type="password" placeholder="Ingrese la contraseña del docente"
                                    class="form-control @error('contrasena') is-invalid @enderror" name="contrasena"
                                    required autocomplete="current-password">

                                @error('contrasena')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-warning btn-block">
                                    <i class="fas fa-sign-in-alt"></i> Entrar al Sistema
                                </button>
                            </div>
                        </div>
                        <a href="#" class="mt-2" data-toggle="modal" data-target="#recuperaCuenta">
                            <p class="mt-2" style="text-align:end">Olvidaste tu contraseña ?</p>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="recuperaCuenta" tabindex="-1" role="dialog" aria-labelledby="myModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-block" style="text-align: center;">
                    <div class="d-flex">
                        <h5 class='col-12 modal-title text-center'>
                            <i class="bi bi-box-arrow-in-down"></i> Recuperar contraseña olvidada
                        </h5>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form id="formRecuperacion" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="correoRecuperacion" class="col-sm-3 col-form-label">Correo
                                    electrónico</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="correoRecuperacion"
                                        name="correoRecuperacion" placeholder="Ingrese el correo electrónico">
                                </div>
                            </div>
                        </form>
                        <center><button class="btn btn-warning btn-block" id="enviaCorreoRecuperacion"><i
                                    class="bi bi-envelope"></i> Solicitar recuperación de cuenta</button></center>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times-circle"></i>
                        Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/login/login.js') }}"></script>
@endsection
