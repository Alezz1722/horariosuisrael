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
                regexContrasena:true,
                minlength: 5,
            },
            confContrasenaUsuario: {
                required: true,
                regexContrasena:true,
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

    $("#formUsuario").validate({
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
        },
        messages: {
            nombreUsuario: {
                required: "Ingrese un nombre",
            },
            apellidoUsuario: {
                required: "Ingrese un apellido"
            },
            correoUsuario: {
                required: "Ingrese un e-mail",
                email: "Ingrese un correo electrónico válido"
            },
        }
    });


    jQuery.validator.addMethod("regexContrasena", function(value, element) {
        return validar_clave(value);
    }, "La clave debe tener mínimo 8 caracteres con al menos una letra mayúscula, un número y un simbolo.");

    function validar_clave(contrasenna) {
        if (contrasenna.length >= 8) {
            var mayuscula = false;
            var minuscula = false;
            var numero = false;
            var caracter_raro = false;

            for (var i = 0; i < contrasenna.length; i++) {
                if (contrasenna.charCodeAt(i) >= 65 && contrasenna.charCodeAt(i) <= 90) {
                    mayuscula = true;
                }
                else if (contrasenna.charCodeAt(i) >= 97 && contrasenna.charCodeAt(i) <= 122) {
                    minuscula = true;
                }
                else if (contrasenna.charCodeAt(i) >= 48 && contrasenna.charCodeAt(i) <= 57) {
                    numero = true;
                }
                else {
                    caracter_raro = true;
                }
            }
            if (mayuscula == true && minuscula == true && caracter_raro == true && numero == true) {
                return true;
            }
        }
        return false;
    }
});
