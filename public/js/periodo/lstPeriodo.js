$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.borrarPeriodo').click(function(e){
        e.preventDefault();

        var idPeriodo = $(this).find(".idPeriodo").text();
        var nombrePeriodo = $(this).find(".nombrePeriodo").text();
        swal({
            title: "Confirmación de eliminación",
            text: "Esta seguro de eliminar el periodo : "+nombrePeriodo+"?",
            icon: "warning",
            buttons: [
              'Cancelar',
              'Eliminar Periodo'
            ],
            dangerMode: true,
          }).then(function(isConfirm) {
            if (isConfirm) {
                $('.loading').attr("hidden",false);
                $.ajax({
                    url: '/periodo/eliminar/'+idPeriodo,
                    type:'DELETE',
                    dataType: 'JSON',
                    //data: data,
                    success: function(data) {
                        $('.loading').attr("hidden",true);
                        if(data.success){
                            swal({
                                title: "Periodo eliminado",
                                text: "El periodo "+$(this).find(".nombrePeriodo").text()+"fue registrado exitosamente!",
                                icon: "success",
                                type: "success"
                            }).then(function(){
                                window.location.href = "/periodo";
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
