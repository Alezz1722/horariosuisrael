$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var data;
    $('#formLugar').submit(function(e){
        e.preventDefault();
        data = $(this).serializeArray();

        console.log(data);

        $.ajax({
            url: '/lugar/validar',
            type:'POST',
            dataType: 'JSON',
            data: data,
            success: function(data) {
                if(data.error){
                    $(".listaErrores").html('');
                    $('.alert-danger').show();
                    $.each(data.error, function(index, value) {
                        $(".listaErrores").append('<li>'+value+'</li>');
                    });
                }
                if(data.success){
                    $('.alert-danger').hide();
                    registraLugar();
                }
            }
        });
    });

    function registraLugar(){

        swal({
            title: "Confirmación de registro",
            text: "Esta seguro de registrar el lugar : "+$("#nombreLugar").val()+"?",
            icon: "warning",
            buttons: [
              'Cancelar',
              'Registrar Lugar'
            ],
          }).then(function(isConfirm) {
            if (isConfirm) {
                $('.loading').attr("hidden",false);
                $.ajax({
                    url: '/lugar/crear',
                    type:'POST',
                    dataType: 'JSON',
                    data: data,
                    success: function(data) {

                        $('.loading').attr("hidden",true);

                        if(data.success){
                            $('.alert-danger').hide();
                            swal({
                                title: "Lugar registrado",
                                text: "El lugar fue registrado exitosamente!",
                                icon: "success",
                                type: "success"
                            }).then(function(){
                                window.location.href = "/lugar";
                            }
                            );
                        }
                        if(data.error){
                            swal({
                                title: "Error al registrar el lugar",
                                text: data.error,
                                icon: "error",
                                type: "error"
                            }).then(function(){
                                //window.location.href = "/periodo";
                            }
                            );
                        }

                    }
                });
            }
          })
    }


});
