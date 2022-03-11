$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.borrarLugar').click(function(e){
        e.preventDefault();

        var idLugar = $(this).find(".idLugar").text();
        var nombreLugar = $(this).find(".nombreLugar").text();
        swal({
            title: "Confirmación de eliminación",
            text: "Esta seguro de eliminar el lugar : "+nombreLugar+"?",
            icon: "warning",
            buttons: [
              'Cancelar',
              'Eliminar Lugar'
            ],
            dangerMode: true,
          }).then(function(isConfirm) {
            if (isConfirm) {
                $('.loading').attr("hidden",false);
                $.ajax({
                    url: '/lugar/eliminar/'+idLugar,
                    type:'DELETE',
                    dataType: 'JSON',
                    //data: data,
                    success: function(data) {
                        $('.loading').attr("hidden",true);
                        if(data.success){
                            swal({
                                title: "Lugar eliminado",
                                text: "El lugar "+$(this).find(".nombreLugar").text()+"fue registrado exitosamente!",
                                icon: "success",
                                type: "success"
                            }).then(function(){
                                window.location.href = "/lugar";
                            }
                            );
                        }
                        if(data.error){
                            swal({
                                title: "Error al eliminar el periodo",
                                text: "El periodo ya pertenece a alguna actividad.",
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
