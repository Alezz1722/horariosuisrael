$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var data;
    $('#formEditaActividad').submit(function(e){
        e.preventDefault();
        data = $(this).serializeArray();


        $.ajax({
            url: '/actividad/validar',
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
                    editaActividad();
                }
            }
        });

    });

    function editaActividad(){
        swal({
            title: "Confirmación de edición",
            text: "Esta seguro de editar la actividad : "+$(".nombreActividad").text()+"?",
            icon: "warning",
            buttons: [
              'Cancelar',
              'Editar Actividad'
            ],
          }).then(function(isConfirm) {
            if (isConfirm) {
                $('.loading').attr("hidden",false);
                $.ajax({
                    url: '/actividad/editar/'+$(".idActividad").text(),
                    type:'PUT',
                    dataType: 'JSON',
                    data: data,
                    success: function(data) {
                        $('.loading').attr("hidden",true);
                        if(data.success){
                            $('.alert-danger').hide();
                            swal({
                                title: "Actividad editada",
                                text: "La actividad fue editada exitosamente!",
                                icon: "success",
                                type: "success"
                            }).then(function(){
                                window.location.href = "/actividad";
                            }
                            );
                        }
                    }
                });
            }
          })
    }



});
