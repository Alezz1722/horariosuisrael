$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //DECLARACION DE VARIABLES
    //1. Toma las fechas inicio, fin del periodo de la actividad correspondiente
    var fechaInicio=$('.fechaInicioPeriodo').text();
    var fInicioPeriodo = fechaInicio.split("-")
    var fechaInicioPeriodo = new Date(fInicioPeriodo[0], fInicioPeriodo[1] - 1, fInicioPeriodo[2]);

    var fechaFin=$('.fechaFinPeriodo').text();
    var fFinPeriodo = fechaFin.split("-")
    var fechaFinPeriodo = new Date(fFinPeriodo[0], fFinPeriodo[1] - 1, fFinPeriodo[2]);


    $('#frecuenciaFecha').on('change', function() {
        resetFormulario();

        if(this.value=='frecuenciaUnaVez'){
            //Cuando solamente escoje la fecha una vez
            $('#fechaInicioFecha').prop( "disabled", false );
            $('#horaInicioFecha').prop( "disabled", false );
            $('#horaFinFecha').prop( "disabled", false );
            $('#fechaFinFecha').val($('#fechaInicioFecha').val());
            estableceDiaSelect();
        }else
        if(this.value=='frecuenciaUnaVezSemana'){
            //Cuando quiere una vez a la semana
            $('#fechaInicioFecha').prop( "disabled", false );
            $('#fechaFinFecha').prop( "disabled", false );
            $('#horaInicioFecha').prop( "disabled", false );
            $('#horaFinFecha').prop( "disabled", false );
            $('#diaFecha').prop( "disabled", false );
        }
      });

    function estableceDiaSelect(){
        const diasSemana = ["domingo","lunes","martes","miercoles","jueves","viernes","sabado"];
        var fecha = $('#fechaInicioFecha').val();
        fInicioPeriodo = (fecha).split("-");
        fechaInicioPeriodo = new Date(fInicioPeriodo[2], fInicioPeriodo[1] - 1, fInicioPeriodo[0]);
        var fechaNum = fechaInicioPeriodo.getDay();
        $('#diaFecha').val(diasSemana[fechaNum]);
    }

    function resetFormulario(){
        fi = (fechaInicio).split("-");
        fi = fi[2]+'-'+fi[1]+'-'+fi[0];
        ff = (fechaFin).split("-");
        ff = ff[2]+'-'+ff[1]+'-'+ff[0];
        $('#fechaInicioFecha').prop( "disabled", true );
        $('#fechaFinFecha').prop( "disabled", true );
        $('#horaInicioFecha').prop( "disabled", true );
        $('#horaFinFecha').prop( "disabled", true );
        $('#diaFecha').prop( "disabled", true );
        $('#fechaInicioFecha').val(fi);
        $('#fechaFinFecha').val(ff);
        $('#horaInicioFecha').val(null);
        $('#horaFinFecha').val(null);
        $('#diaFecha').val(null);

        $('#diaFecha')
                .find('option')
                .remove()
                .end()
                .append('<option value="">Establezca el día inicio ..</option>')
                .val('');

        agregaDiasSelect(0);
        agregaDiasSelect(1);
        agregaDiasSelect(2);
        agregaDiasSelect(3);
        agregaDiasSelect(4);
        agregaDiasSelect(5);
        agregaDiasSelect(6);

    }


    $('#fechaInicioFecha').on('dp.change', function (e) {
        //generaFrecuencia();
        if($('#frecuenciaFecha').val()=='frecuenciaUnaVez'){
            //Cuando solamente escoje la fecha una vez
            $('#fechaFinFecha').val($('#fechaInicioFecha').val());
            estableceDiaSelect();
        }
        if($('#frecuenciaFecha').val()=='frecuenciaUnaVezSemana'){
            //Cuando quiere una vez a la semana
            generaFrecuencia();
        }
    });

    $('#fechaFinFecha').on('dp.change', function (e) {
        generaFrecuencia();
    });

    function generaFrecuencia(){


        if(($("#fechaInicioFecha").val() != '') && ($("#fechaFinFecha").val() != '') && $('#frecuenciaFecha').val() == 'frecuenciaUnaVezSemana'){

            inicioPeriodo = $("#fechaInicioFecha").val();
            fInicioPeriodo = (inicioPeriodo).split("-");
            fechaInicioPeriodo = new Date(fInicioPeriodo[2], fInicioPeriodo[1] - 1, fInicioPeriodo[0]);

            finPeriodo = $("#fechaFinFecha").val();
            fFinPeriodo = (finPeriodo).split("-");
            fechaFinPeriodo = new Date(fFinPeriodo[2], fFinPeriodo[1] - 1, fFinPeriodo[0]);

            var dif = fechaFinPeriodo - fechaInicioPeriodo ;
            var dias = Math.floor(dif / (1000 * 60 * 60 * 24))+1;

            $('#diaFecha')
                .find('option')
                .remove()
                .end()
                .append('<option value="">Establezca el día inicio ..</option>')
                .val('');

            if(dias==1){//Una vez

                    agregaDiasSelect(fechaInicioPeriodo.getDay());
            }

            if(dias>1 && dias<7){ //Entre 2 y 6 dias

                var j = fechaInicioPeriodo.getDay();

                for (var i=0; i<dias; i++) {

                    agregaDiasSelect(j);
                    j++;
                    if(j>6){ j=0;}
                }

            }

            if(dias>6){
                agregaDiasSelect(0);
                agregaDiasSelect(1);
                agregaDiasSelect(2);
                agregaDiasSelect(3);
                agregaDiasSelect(4);
                agregaDiasSelect(5);
                agregaDiasSelect(6);
            }
        }
    }

    function agregaDiasSelect(numeroDia){
        const diasSemana = ["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado"];
        const diassemana = ["domingo","lunes","martes","miercoles","jueves","viernes","sabado"];
        $('#diaFecha').append($('<option>', {
            value: diassemana[numeroDia],
            text: diasSemana[numeroDia]
        }));
    }

    var data;
    $('#formFecha').submit(function(e){
        e.preventDefault();

        if($('#frecuenciaFecha').val()=='frecuenciaUnaVez'){
            $('#fechaFinFecha').prop( "disabled", false );
            $('#diaFecha').prop( "disabled", false );
        }

        data = $(this).serializeArray();

        $.ajax({
            url: '/fecha/validar',
            type:'POST',
            dataType: 'JSON',
            data: data,
            success: function(data) {
                if($('#frecuenciaFecha').val()=='frecuenciaUnaVez'){
                    $('#fechaFinFecha').prop( "disabled", true );
                    $('#diaFecha').prop( "disabled", true );
                }
                if(data.error){
                    $(".listaErrores").html('');
                    $('.alert-danger').show();
                    $.each(data.error, function(index, value) {
                        $(".listaErrores").append('<li>'+value+'</li>');
                    });
                }
                if(data.success){
                    $('.alert-danger').hide();
                    registraFecha();
                }
            }
        });

    });

    function registraFecha(){

        swal({
            title: "Confirmación de registro",
            text: "Esta seguro de registrar el horario establecido ?",
            icon: "warning",
            buttons: [
              'Cancelar',
              'Registrar horario'
            ],
          }).then(function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: '/fecha/crear',
                    type:'POST',
                    dataType: 'JSON',
                    data: data,
                    success: function(data) {



                        if(data.success){
                            $('.alert-danger').hide();
                            swal({
                                title: "Horario registrado",
                                text: "El horario fue registrado exitosamente!",
                                icon: "success",
                                type: "success"
                            }).then(function(){
                                window.location.href = "/fecha?id="+$('#idActividad').val();
                            }
                            );
                        }else{
                            swal({
                                title: "Error",
                                text: data.error,
                                icon: "error",
                                type: "error"
                            })
                        }

                    }
                });
            }
          })
    }

    $("#fechaInicioFecha").datetimepicker({
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

        minDate:fechaInicioPeriodo,
        defaultDate: fechaInicioPeriodo,
        maxDate:fechaFinPeriodo,
        useCurrent: false

    });

    $("#fechaFinFecha").datetimepicker({
        format: 'DD-MM-YYYY',
        locale:  moment.locale('es', {
            week: { dow: 1 }
        }),
        minDate:fechaInicioPeriodo,
        maxDate:fechaFinPeriodo,
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
        defaultDate: fechaFinPeriodo,
        useCurrent: false
    });

    $("#horaInicioFecha").datetimepicker({
        format: 'HH:mm',
        locale:  moment.locale('es', {
            week: { dow: 1 }
        }),
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
        }
    });

    $("#horaFinFecha").datetimepicker({
        format: 'HH:mm',
        locale:  moment.locale('es', {
            week: { dow: 1 }
        }),
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
        }
    });

    $('#horaFinFecha').on('dp.change', function (e) {

        dateBegin = $('#horaInicioFecha').val().split(":");
        begin = new Date();
        begin.setHours(dateBegin[0]);
        begin.setMinutes(dateBegin[1]);

        dateEnd = $('#horaFinFecha').val().split(":");
        end = new Date();
        end.setHours(dateEnd[0]);
        end.setMinutes(dateEnd[1]);

    });

});
