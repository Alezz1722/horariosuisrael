$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#formRecuperacion").validate({
        rules: {
            correoRecuperacion: {
                required: true,
                email: true
            },
        },
        messages: {
            correoRecuperacion: {
                required: "El campo correo electrónico es requerido",
                email: "Ingrese un correo electrónico válido"
            }
        }
    });

    $('#enviaCorreoRecuperacion').click(function(e){
        e.preventDefault();
        if($("#formRecuperacion").valid()){
            data = $("#formRecuperacion").serializeArray();

            $.ajax({
                url: '/recuperaContrasena',
                type:'POST',
                dataType: 'JSON',
                data: data,
                success: function(data) {
                    console.log(data);

                    swal({
                        title: "Petición enviada",
                        text: "Si el usuario se encuentra registrado te llegará un correo de recuperación de contraseña. Por favor revisa tu bandeja de entrada de correo.",
                        icon: "success",
                        type: "success"
                    }).then(function(){
                        window.location.href = "/login";
                    });

                }
            });
        }
    });
});
