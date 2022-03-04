@extends('plantilla')

@section('contenidoPrincipal')
    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4><i class="bi bi-person-check"></i> Hola {{ $usuario->nombreUsuario }}
                        {{ $usuario->apellidoUsuario }} </h4>
                    <br>
                    <p style="text-align: end;">Su cuenta ha sido confirmada y activada con exito.</p>
                </div>
            </div>
        </div>
    </div>
