$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.borrarRecurso').click(function(e){
        e.preventDefault();

        var idRecurso = $(this).find(".idRecurso").text();
        swal({
            title: "Confirmación de eliminación",
            text: "Esta seguro de eliminar el recurso '"+$(this).find(".nombreRecurso").text()+"' ?",
            icon: "warning",
            buttons: [
              'Cancelar',
              'Eliminar Horario'
            ],
            dangerMode: true,
          }).then(function(isConfirm) {
            if (isConfirm) {
                $('.loading').attr("hidden",false);
                $.ajax({
                    url: '/recurso/eliminar/'+idRecurso,
                    type:'DELETE',
                    dataType: 'JSON',
                    //data: data,
                    success: function(data) {
                        $('.loading').attr("hidden",true);
                        if(data.success){
                            swal({
                                title: "Recurso eliminado",
                                text: "El recurso fue eliminado exitosamente!",
                                icon: "success",
                                type: "success"
                            }).then(function(){
                                window.location.href = "/recurso?id="+$('#idActividad').val();
                            }
                            );
                        }
                        if(data.error){
                            swal({
                                title: "Error al eliminar el periodo",
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




    });
});
