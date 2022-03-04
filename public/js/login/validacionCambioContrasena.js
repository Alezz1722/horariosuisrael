$(document).ready(function(){

    $("#formCambioContrasena").validate({
        rules: {
            contrasenaUsuario: {
                required: true,
                minlength: 5,
            },
            confirmaContrasenaUsuario: {
                required: true,
                minlength: 5,
                equalTo: "#contrasenaUsuario",
            },
        },
        messages: {
            contrasenaUsuario: {
                required: "El campo contraseña es requerido",
                minlength: jQuery.validator.format("Al menos {0} caracteres minimos!"),
            },
            confirmaContrasenaUsuario: {
                required: "La confirmación del campo contraseña es requerido",
                minlength: jQuery.validator.format("Al menos {0} caracteres minimos!"),
                equalTo: "Las contraseñas no coinciden",
            },
        }
    });
});
