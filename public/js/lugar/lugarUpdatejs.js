$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var data;
    $('#formEditaLugar').submit(function(e){
        e.preventDefault();
        data = $(this).serializeArray();


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
                    editaLugar();
                }
            }
        });

    });

    function editaLugar(){

        swal({
            title: "Confirmación de edición",
            text: "Esta seguro de editar el lugar : "+$(".nombreLugar").text()+"?",
            icon: "warning",
            buttons: [
              'Cancelar',
              'Editar Lugar'
            ],
          }).then(function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: '/lugar/editar/'+$(".idLugar").text(),
                    type:'PUT',
                    dataType: 'JSON',
                    data: data,
                    success: function(data) {
                        if(data.success){
                            $('.alert-danger').hide();
                            swal({
                                title: "Lugar editado",
                                text: "El lugar fue editado exitosamente!",
                                icon: "success",
                                type: "success"
                            }).then(function(){
                                window.location.href = "/lugar";
                            }
                            );
                        }
                    }
                });
            }
          })
    }



});
