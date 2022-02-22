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
                    editaRecurso();
                }
            }
        });

    });

    function editaRecurso(){

        swal({
            title: "Confirmación de edición",
            text: "Esta seguro de editar el recurso '"+$(".nombreRecurso").val()+"' ?",
            icon: "warning",
            buttons: [
              'Cancelar',
              'Editar Recurso'
            ],
          }).then(function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: '/recurso/editar/'+$("#idRecurso").text(),
                    type:'PUT',
                    dataType: 'JSON',
                    data: data,
                    success: function(data) {
                        console.log(data);

                        if(data.success){
                            $('.alert-danger').hide();
                            swal({
                                title: "Recurso editado",
                                text: "El recurso fue editado exitosamente!",
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
