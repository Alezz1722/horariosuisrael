$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var data;
    $('#formRecurso').submit(function(e){
        e.preventDefault();


        data = $(this).serializeArray();
        $.ajax({
            url: '/recurso/validar',
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
                    registraRecurso();
                }
            }
        });

    });

    function registraRecurso(){

        swal({
            title: "Confirmación de registro",
            text: "Esta seguro de registrar el recurso '"+$(".nombreRecurso").val()+"' en la actividad '"+$("#nombreActividad").val()+"'",
            icon: "warning",
            buttons: [
              'Cancelar',
              'Registrar Recurso'
            ],
          }).then(function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: '/recurso/crear',
                    type:'POST',
                    dataType: 'JSON',
                    data: data,
                    success: function(data) {

                        if(data.success){
                            $('.alert-danger').hide();
                            swal({
                                title: "Recurso registrado",
                                text: "El recurso fue registrado exitosamente!",
                                icon: "success",
                                type: "success"
                            }).then(function(){
                                window.location.href = "/recurso?id="+$('#idActividad').val();
                            }
                            );
                        }
                    }
                });
            }
          })
    }

});
