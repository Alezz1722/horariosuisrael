
$(document).ready(function(){


    $("#semanaDatePicker").datetimepicker({
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
        }
    });

    //Genesis de todo
    var informacion,firstDate,lastDate;
    $('#semanaDatePicker').on('dp.change', function (e) {
        var value = $("#semanaDatePicker").val();
        firstDate = moment(value, "DD-MM-YYYY").day(1).format("DD-MM-YYYY");
        lastDate =  moment(value, "DD-MM-YYYY").day(7).format("DD-MM-YYYY");
        obtieneInformacion();
    });

    function obtieneInformacion(){

        $.ajax({
            url: '/docente/listarSemana',
            type:'GET',
            dataType: 'JSON',
            data: { fechaInicio : firstDate , fechaFin : lastDate },
            success: function(data) {
                informacion = data['success'];
                estableceEstructura(data);
            }
        });
        $("#semanaDatePicker").val("Del "+firstDate + " al " + lastDate);
    }

    $('#semanaDatePicker').on('dp.hide', function (e) {
        var value = $("#semanaDatePicker").val();
        var firstDate = moment(value, "DD-MM-YYYY").day(1).format("DD-MM-YYYY");
        var lastDate =  moment(value, "DD-MM-YYYY").day(7).format("DD-MM-YYYY");
        $("#semanaDatePicker").val("Del "+firstDate + " al " + lastDate);
    });

    $('#semanaDatePicker').data("DateTimePicker").date(new Date());

    function estableceEstructura(data){

        var elementos= data['success'];

        var ths='';
        var tds='';
        var contador = 0,numeroObjetosMayor=0,f=[];
        $.each( elementos, function( fecha, contenido ) {
            switch(contador){
                case 0:
                    ths = ths + '<th style="width: 14.28%"><center>Lunes<br>'+fecha+'</center></th>';
                    f.push(fecha);
                    if(numeroObjetosMayor<contenido.length){
                        numeroObjetosMayor=contenido.length;
                    }
                    break;
                case 1:
                    ths = ths + '<th style="width: 14.28%"><center>Martes<br>'+fecha+'</center></th>';
                    f.push(fecha);
                    if(numeroObjetosMayor<contenido.length){
                        numeroObjetosMayor=contenido.length;
                    }
                    break;
                case 2:
                    ths = ths + '<th style="width: 14.28%"><center>Miercoles<br>'+fecha+'</center></th>';
                    f.push(fecha);
                    if(numeroObjetosMayor<contenido.length){
                        numeroObjetosMayor=contenido.length;
                    }
                    break;
                case 3:
                    ths = ths + '<th style="width: 14.28%"><center>Jueves<br>'+fecha+'</center></th>';
                    f.push(fecha);
                    if(numeroObjetosMayor<contenido.length){
                        numeroObjetosMayor=contenido.length;
                    }
                    break;
                case 4:
                    ths = ths + '<th style="width: 14.28%"><center>Viernes<br>'+fecha+'</center></th>';
                    f.push(fecha);
                    if(numeroObjetosMayor<contenido.length){
                        numeroObjetosMayor=contenido.length;
                    }
                    break;
                case 5:
                    ths = ths + '<th style="width: 14.28%"><center>Sábado<br>'+fecha+'</center></th>';
                    f.push(fecha);
                    if(numeroObjetosMayor<contenido.length){
                        numeroObjetosMayor=contenido.length;
                    }
                    break;
                case 6:
                    ths = ths + '<th style="width: 14.28%"><center>Domingo<br>'+fecha+'</center></th>';
                    f.push(fecha);
                    if(numeroObjetosMayor<contenido.length){
                        numeroObjetosMayor=contenido.length;
                    }
                    break;
            }
            tds = tds + '<td class="'+fecha+'"></td>';
            contador++;


            if(contador==7){
                dibujaCabezera(ths);
                dibujaCuerpo(data,tds,numeroObjetosMayor,f);

            }
        });
    }

    function dibujaCabezera(data){
        $('#dashboardDocente thead tr').html(data);
    }

    function dibujaCuerpo(data,tds,nroObjetos,f){

        if(nroObjetos==0){
            $('#dashboardDocente tbody').html('');
            $('.notificacion').html("<h5><center>No existen actividades registradas</center></h5>");
        }else{
            $('.notificacion').html("");
            $('#dashboardDocente tbody').html("");

            for(var i=0;i<nroObjetos;i++){
                var tr  = '<tr>';
                tr = tr + '<td id="trjActividad" class="'+f[0]+' '+i+'" style="width: 14.28%">';

                if(data['success'][f[0]][i] != undefined){
                    //Para actividades del dia Lunes
                    tr = tr + tarjetaActividad(data['success'][f[0]][i],f[0]);
                }

                tr=  tr +'</td>';
                tr = tr + '<td id="trjActividad" class="'+f[1]+' '+i+'" style="width: 14.28%">';

                if(data['success'][f[1]][i] != undefined){
                    //Para actividades del dia Martes
                    tr = tr + tarjetaActividad(data['success'][f[1]][i],f[1]);
                }

                tr=  tr +'</td>';
                tr = tr + '<td id="trjActividad" class="'+f[2]+' '+i+'" style="width: 14.28%">';

                if(data['success'][f[2]][i] != undefined){
                    //Para actividades del dia Miercoles
                    tr = tr + tarjetaActividad(data['success'][f[2]][i],f[2]);
                }

                tr = tr +'</td>';
                tr = tr + '<td id="trjActividad" class="'+f[3]+' '+i+'" style="width: 14.28%">';


                if(data['success'][f[3]][i] != undefined){
                    //Para actividades del dia Jueves
                    tr = tr + tarjetaActividad(data['success'][f[3]][i],f[3]);
                }

                tr = tr +'</td>';
                tr = tr + '<td id="trjActividad" class="'+f[4]+' '+i+'" style="width: 14.28%">';

                if(data['success'][f[4]][i] != undefined){
                    //Para actividades del dia Viernes
                    tr = tr + tarjetaActividad(data['success'][f[4]][i],f[4]);
                }

                tr = tr +'</td>';
                tr = tr + '<td id="trjActividad" class="'+f[5]+' '+i+'" style="width: 14.28%">';

                if(data['success'][f[5]][i] != undefined){
                    //Para actividades del dia Sabado
                    tr = tr + tarjetaActividad(data['success'][f[5]][i],f[5]);
                }

                tr = tr +'</td>';
                tr = tr + '<td id="trjActividad" class="'+f[6]+' '+i+'" style="width: 14.28%">';

                if(data['success'][f[6]][i] != undefined){
                    //Para actividades del dia Domingo
                    tr = tr + tarjetaActividad(data['success'][f[6]][i],f[6]);
                }

                tr = tr +'</td>';
                tr = tr + '<tr>';
                $('#dashboardDocente tbody').append(tr);
            }
        }

    }

    function tarjetaActividad(data,fAsignada){
        var html='';

        html = html + '<div class="card" style="cursor: pointer;" data-toggle="modal" data-target="#myModal">';
        //Para establecer las horas
        if(data.estadoListadoFecha == 'APLAZADA' && data.fechaAplazadaListadoFecha == fAsignada){
            html = html + '<h6 class="card-header"><center>De '+data.horaInicioAplazadaListadoFecha.slice(0,5)+' a '+data.horaFinAplazadaListadoFecha.slice(0,5)+'</h6></center>';
        }else{
            html = html + '<h6 class="card-header"><center>De '+data.horaInicioListadoFecha.slice(0,5)+' a '+data.horaFinListadoFecha.slice(0,5)+'</h6></center>';
        }
        //Para establecer el color de las tarjetas
        if(data.estadoListadoFecha == 'ACTIVA'){
            html = html + '<div class="card-body text-white bg-success">';
        }else
        if(data.estadoListadoFecha == 'APLAZADA' && data.fechaAplazadaListadoFecha == fAsignada){
            html = html + '<div class="card-body text-white bg-success">';
        }else
        if(data.estadoListadoFecha == 'APLAZADA' && data.fechaAplazadaListadoFecha != fAsignada){
            html = html + '<div class="card-body text-white bg-warning">';
        }else
        if(data.estadoListadoFecha == 'CANCELADA'){
            html = html + '<div class="card-body text-white bg-dark">';
        }
        html = html + '<h6 class="card-title" style="text-align: center;">'+data.idFecha.idActividad.nombreActividad+'</h6>';
        html = html + '</div>';
        html = html + '<div class="card-footer">';
        html = html + '<h5 style="text-align: left;">'+data.idFecha.idActividad.idLugar.aulaLugar+'</h5>';
        html = html + '<p style="text-align: end;">'+data.idFecha.idActividad.idLugar.nombreLugar+'</p>';
        html = html + '</div>';
        html = html + '</div>';
        return html
    }

    var fechaInicioPeriodo,fechaFinPeriodo,fecha,hinicio,hfin,actividad;
    $('#dashboardDocente').on('click','#trjActividad', function(){
        var clase = ($(this).attr('class')).split(' ');
        actividad = informacion[clase[0]][clase[1]];

        if(actividad!=undefined){

            $('#estadoActividad').val(actividad.estadoListadoFecha);



            //Asignacion de titulos
            $('#myModal .modal-title').text(actividad.idFecha.idActividad.nombreActividad);
            $('#myModal .modal-subtitle1').text(actividad.fechaListadoFecha);
            $('#myModal .modal-subtitle2').text(actividad.horaInicioListadoFecha.slice(0,5)+ " / "+ actividad.horaFinListadoFecha.slice(0,5));

            //Asignacion de informacion dentro del modal

            $('#myModal .modalActividad').html(actividad.idFecha.idActividad.descripcionActividad);

            switch(actividad.idFecha.frecuenciaFecha){
                case 'frecuenciaUnaVez':
                    $('#myModal .modalFrecuencia').html("Una sola vez<br>Día : "+actividad.idFecha.diaFecha+" ("+actividad.idFecha.fechaInicioFecha+")<br> Hora asignada : "+actividad.idFecha.horaInicioFecha.slice(0,5)+" / "+actividad.idFecha.horaFinFecha.slice(0,5));
                    var fInicioPeriodo1 = (actividad.idFecha.idActividad.idPeriodo.fechaInicioPeriodo).split("-");
                    fechaInicioPeriodo = new Date(fInicioPeriodo1[0], fInicioPeriodo1[1] - 1, fInicioPeriodo1[2]);
                    var fFinPeriodo1 = (actividad.idFecha.idActividad.idPeriodo.fechaFinPeriodo).split("-");
                    fechaFinPeriodo = new Date(fFinPeriodo1[0], fFinPeriodo1[1] - 1, fFinPeriodo1[2]);
                    break;
                case 'frecuenciaUnaVezSemana':
                    $('#myModal .modalFrecuencia').html("Una vez a la semana<br>Día : "+actividad.idFecha.diaFecha+"<br>Fecha asignada : De "+actividad.idFecha.fechaInicioFecha+" a <br>"+actividad.idFecha.fechaFinFecha+"<br> Hora asignada : "+actividad.idFecha.horaInicioFecha.slice(0,5)+" / "+actividad.idFecha.horaFinFecha.slice(0,5));
                    var fInicioPeriodo1 = (actividad.idFecha.fechaInicioFecha).split("-");
                    fechaInicioPeriodo = new Date(fInicioPeriodo1[0], fInicioPeriodo1[1] - 1, fInicioPeriodo1[2]);
                    var fFinPeriodo1 = (actividad.idFecha.fechaFinFecha).split("-");
                    fechaFinPeriodo = new Date(fFinPeriodo1[0], fFinPeriodo1[1] - 1, fFinPeriodo1[2]);
                    break;
            }

            $('#myModal .modalPeriodo').html(actividad.idFecha.idActividad.idPeriodo.nombrePeriodo+"<br>"+actividad.idFecha.idActividad.idPeriodo.descripcionPeriodo+"<br>"+actividad.idFecha.idActividad.idPeriodo.fechaInicioPeriodo+" / "+actividad.idFecha.idActividad.idPeriodo.fechaFinPeriodo);

            $('#myModal .modalRecursos').html("");
            if(actividad.idFecha.idActividad.idRecurso.length>0){
                $.each( actividad.idFecha.idActividad.idRecurso, function( key, value ) {
                    $('#myModal .modalRecursos').append("<a href='"+value.urlRecurso+"' target='_blank' >"+value.nombreRecurso+"<hr>");
                });
            }else{
                $('#myModal .modalRecursos').html("Ninguno");
            }

            analizaEstadoActividad(actividad.estadoListadoFecha);

        }

    });

    function analizaEstadoActividad(estado){
        resetForm();

        if($('#estadoActividad').val() == "ACTIVA"){
            $("#submitFormFecha").attr("hidden",false);
        }else
        if($('#estadoActividad').val() == "APLAZADA" && actividad.estadoListadoFecha == "APLAZADA"){

            var f = (actividad.fechaAplazadaListadoFecha).split("-");
            fecha = f[2]+'-'+f[1] +'-'+f[0];
            hinicio = actividad.horaInicioAplazadaListadoFecha.slice(0,5);
            hfin = actividad.horaFinAplazadaListadoFecha.slice(0,5);

            $(".brForm").attr("hidden",false);
            $(".brFormCancelado").attr("hidden",false);
            $(".fechaForm").attr("hidden",false);
            $(".inicioForm").attr("hidden",false);
            $(".finForm").attr("hidden",false);
            $(".observacionForm").attr("hidden",false);
            $("#submitFormFecha").attr("hidden",false);

            $('#fechaInicio').data("DateTimePicker").minDate(fechaInicioPeriodo);
            $('#fechaInicio').data("DateTimePicker").maxDate(fechaFinPeriodo);
            $('#fechaInicio').val(fecha);
            $("#horaInicio").val(hinicio);
            $("#horaFin").val(hfin);
            $("textarea#observacion").val(actividad.observacionListadoFecha);
        }else
        if($('#estadoActividad').val() == "APLAZADA" && actividad.estadoListadoFecha != "APLAZADA"){

            var f = (actividad.fechaListadoFecha).split("-");
            fecha = f[2]+'-'+f[1] +'-'+f[0];
            hinicio = actividad.horaInicioListadoFecha.slice(0,5);
            hfin = actividad.horaFinListadoFecha.slice(0,5);

            $(".brForm").attr("hidden",false);
            $(".brFormCancelado").attr("hidden",false);
            $(".fechaForm").attr("hidden",false);
            $(".inicioForm").attr("hidden",false);
            $(".finForm").attr("hidden",false);
            $(".observacionForm").attr("hidden",false);
            $("#submitFormFecha").attr("hidden",false);

            $('#fechaInicio').data("DateTimePicker").minDate(fechaInicioPeriodo);
            $('#fechaInicio').data("DateTimePicker").maxDate(fechaFinPeriodo);
            $('#fechaInicio').val(fecha);
            $("#horaInicio").val(hinicio);
            $("#horaFin").val(hfin);
            $("#observacion").val("");
        }else
        if($('#estadoActividad').val() == "CANCELADA" && actividad.estadoListadoFecha == "CANCELADA"){
            $(".brFormCancelado").attr("hidden",false);
            $(".observacionForm").attr("hidden",false);
            $("#submitFormFecha").attr("hidden",false);
            $("#observacion").val(actividad.observacionListadoFecha);
        }else
        if($('#estadoActividad').val() == "CANCELADA" && actividad.estadoListadoFecha != "CANCELADA"){
            $(".brFormCancelado").attr("hidden",false);
            $(".observacionForm").attr("hidden",false);
            $("#submitFormFecha").attr("hidden",false);
            $("#observacion").val("");
        }
    }

    $('#estadoActividad').change(function() {
        analizaEstadoActividad($('#estadoActividad').val());
    });

    function resetForm(){
        $(".brForm").attr("hidden",true);
        $(".fechaForm").attr("hidden",true);
        $(".inicioForm").attr("hidden",true);
        $(".finForm").attr("hidden",true);
        $(".observacionForm").attr("hidden",true);

        $("#horaInicio").val("");
        $("#horaFin").val("");
        $(".observacion").val("");
        $("#fechaInicio").val("");

        $("#submitFormFecha").attr("hidden",true);
        $(".brFormCancelado").attr("hidden",true);
    }

    $('#formFecha').submit(function(e){
        e.preventDefault();
        informacion = $(this).serializeArray();
        aux = {name:'idListadoFecha',value:actividad.idListadoFecha}
        informacion.push(aux);


        if($('#estadoActividad').val()=='ACTIVA'){
            swal({
                title: "Confirmación de edición",
                text: "Esta seguro de asignar el estado a "+$('#estadoActividad').val()+" del horario actual ?",
                icon: "warning",
                buttons: [
                  'Cancelar',
                  'Actualizar Estado'
                ],
              }).then(function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: '/listadofecha/editar/',
                        type:'POST',
                        dataType: 'JSON',
                        data: informacion,
                        success: function(data) {
                            if(data.success){
                                $('.alert-danger').hide();
                                swal({
                                    title: "Horario editado",
                                    text: "El estado del horario fue asignado exitosamente!",
                                    icon: "success",
                                    type: "success"
                                }).then(function(){
                                    obtieneInformacion();
                                }
                                );
                            }
                        }
                    });
                }

              })

        }else
        if($('#estadoActividad').val()=='APLAZADA'){
            $.ajax({
                url: '/listadofecha/validar',
                type:'POST',
                dataType: 'JSON',
                data: informacion,
                success: function(data) {
                    if(data.error){

                        var errores = '/ ';
                        $.each(data.error, function(index, value) {
                            errores = errores + value +" / ";
                        });

                        swal({
                            title: "Error al establecer estado de horario",
                            text: errores,
                            icon: "error",
                            type: "error"
                        });

                    }else{
                        swal({
                            title: "Confirmación de edición",
                            text: "Esta seguro de asignar el estado a "+$('#estadoActividad').val()+" del horario actual ?",
                            icon: "warning",
                            buttons: [
                              'Cancelar',
                              'Actualizar Estado'
                            ],
                        }).then(function(isConfirm) {

                            if (isConfirm) {
                                $.ajax({
                                    url: '/listadofecha/editar/',
                                    type:'POST',
                                    dataType: 'JSON',
                                    data: informacion,
                                    success: function(data) {
                                        if(data.success){
                                            swal({
                                                title: "Horario editado",
                                                text: "El estado del horario fue asignado exitosamente!",
                                                icon: "success",
                                                type: "success"
                                            }).then(function(){
                                                obtieneInformacion();
                                            }
                                            );
                                        }
                                    }
                                });
                            }

                        })

                    }
                }
            });
        }else
        if($('#estadoActividad').val()=='CANCELADA'){
            if($(".observacion").val().length != 0){

                swal({
                    title: "Confirmación de edición",
                    text: "Esta seguro de asignar el estado a "+$('#estadoActividad').val()+" del horario actual ?",
                    icon: "warning",
                    buttons: [
                      'Cancelar',
                      'Actualizar Estado'
                    ],
                }).then(function(isConfirm) {

                    if (isConfirm) {
                        $.ajax({
                            url: '/listadofecha/editar/',
                            type:'POST',
                            dataType: 'JSON',
                            data: informacion,
                            success: function(data) {
                                if(data.success){
                                    swal({
                                        title: "Horario editado",
                                        text: "El estado del horario fue asignado exitosamente!",
                                        icon: "success",
                                        type: "success"
                                    }).then(function(){
                                        obtieneInformacion();
                                    }
                                    );
                                }
                            }
                        });
                    }

                })

            }else{
                swal({
                    title: "Error al establecer estado de horario",
                    text: "El campo observacion es requerido",
                    icon: "error",
                    type: "error"
                });
            }
        }

    });

    $("#fechaInicio").datetimepicker({
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

    $("#horaInicio").datetimepicker({
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
        },
        useCurrent: false
    });

    $("#horaFin").datetimepicker({
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
        },
        useCurrent: false
    });
});
