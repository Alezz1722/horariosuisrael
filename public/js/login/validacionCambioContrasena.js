$(document).ready(function(){

    $("#formCambioContrasena").validate({
        rules: {
            contrasenaUsuario: {
                required: true,
                regexContrasena:true
            },
            confirmaContrasenaUsuario: {
                required: true,
                regexContrasena:true,
                equalTo: "#contrasenaUsuario",
            },
        },
        messages: {
            contrasenaUsuario: {
                required: "El campo contraseña es requerido",
            },
            confirmaContrasenaUsuario: {
                required: "La confirmación del campo contraseña es requerido",
                equalTo: "Las contraseñas no coinciden",
            },
        }
    });

    $("#formCambioContrasenaDocente").validate({
        rules: {
            contrasenaActualDocente: {
                required: true,
                regexContrasena:true
            },
            nuevaContrasenaDocente: {
                required: true,
                regexContrasena:true
            },
            confirmaNuevaContrasenaDocente: {
                required: true,
                regexContrasena:true,
                equalTo: "#nuevaContrasenaDocente",
            },
        },
        messages: {
            contrasenaActualDocente: {
                required: "El campo contraseña actual es requerido",
            },
            nuevaContrasenaDocente: {
                required: "El campo nueva contraseña es requerido",
            },
            confirmaNuevaContrasenaDocente: {
                required: "El campo confirmación nueva contraseña es requerido",
                equalTo: "Las nuevas contraseñas no coinciden",
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
