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
                            <input id="correo" type="email" placeholder="Ingrese el correo electrónico" class="form-control @error('correo') is-invalid @enderror" name="correo" value="{{ old('correo') }}" required autocomplete="correo" autofocus>

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
                            <input id="contrasena" type="password" placeholder="Ingrese la contraseña" class="form-control @error('contrasena') is-invalid @enderror" name="contrasena" required autocomplete="current-password">

                            @error('contrasena')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i> Entrar
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/login/login.js') }}"></script>
@endsection

