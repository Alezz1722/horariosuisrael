$(document).ready(function () {
    $("#formNuevoDocente").validate({
        rules: {
            nombreUsuario: {
                required: true,
            },
            apellidoUsuario: {
                required: true,
            },
            correoUsuario: {
                required: true,
                email: true
            },
            contrasenaUsuario: {
                required: true,
                minlength: 5,
            },
            confContrasenaUsuario: {
                required: true,
                minlength: 5,
                equalTo: "#contrasenaUsuario",
            },
        },
        messages: {
            nombreUsuario: {
                required: "Ingrese un nombre",
            },
            apellidoUsuario: {
                required: "Ingrese un apellido"
            },
            correoUsuario: {
                required: "Ingrese un e-mail ",
                email: "Ingrese un correo electrónico válido"
            },
            contrasenaUsuario: {
                required: "Ingrese una contraseña",
                minlength: jQuery.validator.format("Al menos {0} caracteres minimos!"),
            },
            confContrasenaUsuario: {
                required: "Ingrese nuevamente su contraseña",
                minlength: jQuery.validator.format("Al menos {0} caracteres minimos!"),
                equalTo: "Las contraseñas no coinciden",
            },
        }
    });
});
