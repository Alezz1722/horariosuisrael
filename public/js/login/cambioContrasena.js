$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    console.log("js");

    $("#formCambioContrasena").submit(function(e){
        e.preventDefault();
        if($("#formCambioContrasena").valid()){
            data = $(this).serializeArray();
            console.log("Es valido");
            console.log(data);
            console.log($("#codigoEmprendedor").text());

            $.ajax({
                url: '/password/'+$("#codigoEmprendedor").text(),
                type:'POST',
                dataType: 'JSON',
                data: data,
                success: function(data) {
                    console.log(data);
                    if(data.error){
                        swal({
                            title: "Error al cambiar las contraseñas",
                            text: "Por favor contacte con el administrador del sistema",
                            icon: "error",
                            type: "error"
                        });
                    }
                    if(data.success){
                        swal({
                            title: "Cambio de contraseña",
                            text: "La contraseña se ha cambiado con exito. Por favor inicia sesión con tus nuevas credenciales",
                            icon: "success",
                            type: "success"
                        }).then(function(){
                            window.location.href = "/login";
                        });
                    }
                }
            });
        }
    });
});
