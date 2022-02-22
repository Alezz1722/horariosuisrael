$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var data;
    $('#formActividad').submit(function(e){
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
                    registraActividad();
                }
            }
        });
    });

    function registraActividad(){

        swal({
            title: "Confirmación de registro",
            text: "Esta seguro de registrar la actividad : "+$("#nombreActividad").val()+"?",
            icon: "warning",
            buttons: [
              'Cancelar',
              'Registrar Actividad'
            ],
          }).then(function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: '/actividad/crear',
                    type:'POST',
                    dataType: 'JSON',
                    data: data,
                    success: function(data) {

                        if(data.success){
                            $('.alert-danger').hide();
                            swal({
                                title: "Actividad registrada",
                                text: "La actividad fue registrada exitosamente!",
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
