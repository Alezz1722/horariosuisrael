
$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var data;
    $('#formEditaPeriodo').submit(function(e){
        e.preventDefault();
        data = $(this).serializeArray();

        $.ajax({
            url: '/periodo/validar',
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
                    editaPeriodo();
                }
            }
        });
    });

    function editaPeriodo(){

        swal({
            title: "Confirmación de edición",
            text: "Esta seguro de editar el periodo : "+$(".nombrePeriodo").text()+"?",
            icon: "warning",
            buttons: [
              'Cancelar',
              'Editar Periodo'
            ],
          }).then(function(isConfirm) {
            if (isConfirm) {
                $('.loading').attr("hidden",false);
                $.ajax({
                    url: '/periodo/editar/'+$(".idPeriodo").text(),
                    type:'PUT',
                    dataType: 'JSON',
                    data: data,
                    success: function(data) {
                        $('.loading').attr("hidden",true);
                        if(data.success){
                            $('.alert-danger').hide();
                            swal({
                                title: "Periodo editado",
                                text: "El periodo fue editado exitosamente!",
                                icon: "success",
                                type: "success"
                            }).then(function(){
                                window.location.href = "/periodo";
                            }
                            );
                        }
                    }
                });
            }
          })
    }


    $("#fechaInicioPeriodo").datetimepicker({
        format: 'DD-MM-YYYY',
        locale:  moment.locale('es', {
            week: { dow: 1 }
        }),
        showTodayButton:true,
        icons: {
            time: 'fas fa-clock',
            date: 'fas fa-calendar-week',
            up: 'fas fa-chevron-up',
            down: 'fas fa-chevron-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'fas fa-clock',
        },
        tooltips: {
            today: 'Ir al dia de hoy',
            clear: 'Eliminar seleccion',
            close: 'Cerrar el calendario',
            selectMonth: 'Seleccione el mes',
            prevMonth: 'Anterior mes',
            nextMonth: 'Siguiente mes',
            selectYear: 'Seleccione el año',
            prevYear: 'Anterior año',
            nextYear: 'Siguiente año',
            selectDecade: 'Seleccione la década',
            prevDecade: 'Anterior década',
            nextDecade: 'Siguiente década',
            prevCentury: 'Anterior siglo',
            nextCentury: 'Siguiente siglo'
        },
        defaultDate: $("#fip").text(),
    });


    $("#fechaFinPeriodo").datetimepicker({
        format: 'DD-MM-YYYY',
        locale:  moment.locale('es', {
            week: { dow: 1 }
        }),
        showTodayButton:true,
        icons: {
            time: 'fas fa-clock',
            date: 'fas fa-calendar-week',
            up: 'fas fa-chevron-up',
            down: 'fas fa-chevron-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'fas fa-clock',
        },
        tooltips: {
            today: 'Ir al dia de hoy',
            clear: 'Eliminar seleccion',
            close: 'Cerrar el calendario',
            selectMonth: 'Seleccione el mes',
            prevMonth: 'Anterior mes',
            nextMonth: 'Siguiente mes',
            selectYear: 'Seleccione el año',
            prevYear: 'Anterior año',
            nextYear: 'Siguiente año',
            selectDecade: 'Seleccione la década',
            prevDecade: 'Anterior década',
            nextDecade: 'Siguiente década',
            prevCentury: 'Anterior siglo',
            nextCentury: 'Siguiente siglo'
        },
        defaultDate: $("#ffp").text(),
    });


});
