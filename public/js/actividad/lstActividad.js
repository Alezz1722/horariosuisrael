$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.borrarActividad').click(function(e){
        e.preventDefault();

        var idActividad = $(this).find(".idActividad").text();
        var nombreActividad = $(this).find(".nombreActividad").text();
        swal({
            title: "Confirmación de eliminación",
            text: "Esta seguro de eliminar la actividad : "+nombreActividad+"?",
            icon: "warning",
            buttons: [
              'Cancelar',
              'Eliminar Actividad'
            ],
            dangerMode: true,
          }).then(function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: '/actividad/eliminar/'+idActividad,
                    type:'DELETE',
                    dataType: 'JSON',
                    //data: data,
                    success: function(data) {
                        if(data.success){
                            swal({
                                title: "Actividad eliminada",
                                text: "La actividad "+$(this).find(".nombreActividad").text()+"fue eliminada exitosamente!",
                                icon: "success",
                                type: "success"
                            }).then(function(){
                                window.location.href = "/actividad";
                            }
                            );
                        }
                        if(data.error){
                            swal({
                                title: "Error al eliminar la actividad",
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
