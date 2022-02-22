$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.borrarFecha').click(function(e){
        e.preventDefault();

        var idFecha = $(this).find(".idFecha").text();
        swal({
            title: "Confirmación de eliminación",
            text: "Esta seguro de eliminar el presente horario ?",
            icon: "warning",
            buttons: [
              'Cancelar',
              'Eliminar Horario'
            ],
            dangerMode: true,
          }).then(function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: '/fecha/eliminar/'+idFecha,
                    type:'DELETE',
                    dataType: 'JSON',
                    //data: data,
                    success: function(data) {
                        console.log(data);
                        if(data.success){
                            swal({
                                title: "Horario eliminado",
                                text: "El horario fue eliminado exitosamente!",
                                icon: "success",
                                type: "success"
                            }).then(function(){
                                window.location.href = "/fecha?id="+$('#idActividad').val();
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
