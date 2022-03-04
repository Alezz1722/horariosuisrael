$(document).ready(function () {


    $("#semanaDatePicker").datetimepicker({
        format: 'DD-MM-YYYY',
        locale: moment.locale('es', {
            week: { dow: 1 }
        }),
        showTodayButton: true,
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

    var informacion, firstDate, lastDate;//Genesis de todo
    $('#profesorSelect').on('change', function () {
        validaConsulta();
    });

    $('#semanaDatePicker').on('dp.change', function (e) {
        var value = $("#semanaDatePicker").val();
        firstDate = moment(value, "DD-MM-YYYY").day(1).format("DD-MM-YYYY");
        lastDate = moment(value, "DD-MM-YYYY").day(7).format("DD-MM-YYYY");
        $("#semanaDatePicker").val("Del " + firstDate + " al " + lastDate);
        validaConsulta();
    });

    $('#semanaDatePicker').on('dp.hide', function (e) {
        var value = $("#semanaDatePicker").val();
        var firstDate = moment(value, "DD-MM-YYYY").day(1).format("DD-MM-YYYY");
        var lastDate = moment(value, "DD-MM-YYYY").day(7).format("DD-MM-YYYY");
        $("#semanaDatePicker").val("Del " + firstDate + " al " + lastDate);
    });

    $('#semanaDatePicker').data("DateTimePicker").date(new Date());

    function validaConsulta() {

        //$('#dashboardDocente').html("<thead><tr></tr></thead><tbody></tbody>");
        obtieneInformacion();
    }


    function obtieneInformacion() {

        $.ajax({
            url: '/docente/listarSemana',
            type: 'GET',
            dataType: 'JSON',
            data: { fechaInicio: firstDate, fechaFin: lastDate, idUsuario: $('#profesorSelect').val() },
            success: function (data) {
                informacion = data['success'];
                estableceEstructura(data);
            }
        });
    }


    function estableceEstructura(data) {

        var elementos = data['success'];

        var ths = '';
        var tds = '';
        var contador = 0, numeroObjetosMayor = 0, f = [];
        $.each(elementos, function (fecha, contenido) {
            switch (contador) {
                case 0:
                    ths = ths + '<th><center>Lunes<br>' + fecha + '</center></th>';
                    f.push(fecha);
                    if (numeroObjetosMayor < contenido.length) {
                        numeroObjetosMayor = contenido.length;
                    }
                    break;
                case 1:
                    ths = ths + '<th><center>Martes<br>' + fecha + '</center></th>';
                    f.push(fecha);
                    if (numeroObjetosMayor < contenido.length) {
                        numeroObjetosMayor = contenido.length;
                    }
                    break;
                case 2:
                    ths = ths + '<th><center>Miercoles<br>' + fecha + '</center></th>';
                    f.push(fecha);
                    if (numeroObjetosMayor < contenido.length) {
                        numeroObjetosMayor = contenido.length;
                    }
                    break;
                case 3:
                    ths = ths + '<th><center>Jueves<br>' + fecha + '</center></th>';
                    f.push(fecha);
                    if (numeroObjetosMayor < contenido.length) {
                        numeroObjetosMayor = contenido.length;
                    }
                    break;
                case 4:
                    ths = ths + '<th><center>Viernes<br>' + fecha + '</center></th>';
                    f.push(fecha);
                    if (numeroObjetosMayor < contenido.length) {
                        numeroObjetosMayor = contenido.length;
                    }
                    break;
                case 5:
                    ths = ths + '<th><center>Sábado<br>' + fecha + '</center></th>';
                    f.push(fecha);
                    if (numeroObjetosMayor < contenido.length) {
                        numeroObjetosMayor = contenido.length;
                    }
                    break;
                case 6:
                    ths = ths + '<th><center>Domingo<br>' + fecha + '</center></th>';
                    f.push(fecha);
                    if (numeroObjetosMayor < contenido.length) {
                        numeroObjetosMayor = contenido.length;
                    }
                    break;
            }
            tds = tds + '<td class="' + fecha + '"></td>';
            contador++;


            if (contador == 7) {
                dibujaCabezera(ths);
                dibujaCuerpo(data, tds, numeroObjetosMayor, f);

            }
        });
    }

    function dibujaCabezera(data) {
        $('#dashboardDocente thead tr').html(data);
    }

    function dibujaCuerpo(data, tds, nroObjetos, f) {

        if (nroObjetos == 0) {
            $('#dashboardDocente tbody').html('');
            if ($('#profesorSelect').val() == '') {
                $('.notificacion').html("<b><center>Selecciona un profesor para ver horarios</b>");
            } else {
                $('.notificacion').html("<b><center>No existen actividades registradas</center></b>");
            }

        } else {
            $('.notificacion').html("");
            $('#dashboardDocente tbody').html("");

            for (var i = 0; i < nroObjetos; i++) {
                var tr = '<tr>';
                tr = tr + '<td id="trjActividad" class="' + f[0] + ' ' + i + ' col-md-2"">';

                if (data['success'][f[0]][i] != undefined) {
                    //Para actividades del dia Lunes
                    tr = tr + tarjetaActividad(data['success'][f[0]][i], f[0]);
                }

                tr = tr + '</td>';
                tr = tr + '<td id="trjActividad" class="' + f[1] + ' ' + i + ' col-md-2"">';

                if (data['success'][f[1]][i] != undefined) {
                    //Para actividades del dia Martes
                    tr = tr + tarjetaActividad(data['success'][f[1]][i], f[1]);
                }

                tr = tr + '</td>';
                tr = tr + '<td id="trjActividad" class="' + f[2] + ' ' + i + ' col-md-2" ">';

                if (data['success'][f[2]][i] != undefined) {
                    //Para actividades del dia Miercoles
                    tr = tr + tarjetaActividad(data['success'][f[2]][i], f[2]);
                }

                tr = tr + '</td>';
                tr = tr + '<td id="trjActividad" class="' + f[3] + ' ' + i + ' col-md-2" >';


                if (data['success'][f[3]][i] != undefined) {
                    //Para actividades del dia Jueves
                    tr = tr + tarjetaActividad(data['success'][f[3]][i], f[3]);
                }

                tr = tr + '</td>';
                tr = tr + '<td id="trjActividad" class="' + f[4] + ' ' + i + ' col-md-2" >';

                if (data['success'][f[4]][i] != undefined) {
                    //Para actividades del dia Viernes
                    tr = tr + tarjetaActividad(data['success'][f[4]][i], f[4]);
                }

                tr = tr + '</td>';
                tr = tr + '<td id="trjActividad" class="' + f[5] + ' ' + i + ' col-md-1" >';

                if (data['success'][f[5]][i] != undefined) {
                    //Para actividades del dia Sabado
                    tr = tr + tarjetaActividad(data['success'][f[5]][i], f[5]);
                }

                tr = tr + '</td>';
                tr = tr + '<td id="trjActividad" class="' + f[6] + ' ' + i + ' col-md-1" >';

                if (data['success'][f[6]][i] != undefined) {
                    //Para actividades del dia Domingo
                    tr = tr + tarjetaActividad(data['success'][f[6]][i], f[6]);
                }

                tr = tr + '</td>';
                tr = tr + '<tr>';
                $('#dashboardDocente tbody').append(tr);
            }
        }

    }

    function tarjetaActividad(data, fAsignada) {
        var html = '';

        console.log(data);

        html = html + '<div class="card" style="cursor: pointer;" data-toggle="modal" data-target="#myModal">';
        //Para establecer las horas
        if (data.estadoListadoFecha == 'APLAZADA' && data.fechaAplazadaListadoFecha == fAsignada) {
            html = html + '<h6 class="card-header">De ' + data.horaInicioAplazadaListadoFecha.slice(0, 5) + ' a ' + data.horaFinAplazadaListadoFecha.slice(0, 5) + '</h6>';
        } else {
            html = html + '<h6 class="card-header">De ' + data.horaInicioListadoFecha.slice(0, 5) + ' a ' + data.horaFinListadoFecha.slice(0, 5) + '</h6>';
        }
        //Para establecer el color de las tarjetas
        if (data.estadoListadoFecha == 'ACTIVA') {
            html = html + '<div class="card-body text-white bg-success">';
        } else
            if (data.estadoListadoFecha == 'APLAZADA') {
                //html = html + '<div class="card-body text-white bg-warning">';
                if (data.estadoListadoFecha == 'APLAZADA' && data.fechaAplazadaListadoFecha == fAsignada) {
                    html = html + '<div class="card-body text-white bg-success">';
                } else
                    if (data.estadoListadoFecha == 'APLAZADA' && data.fechaAplazadaListadoFecha != fAsignada) {
                        html = html + '<div class="card-body text-white bg-warning">';
                    }
            } else
                if (data.estadoListadoFecha == 'CANCELADA') {
                    html = html + '<div class="card-body text-white bg-dark">';
                }
        html = html + '<h6 class="card-title" style="text-align: center;">' + data.idFecha.idActividad.nombreActividad + '</h6>';
        html = html + '</div>';
        html = html + '<div class="card-footer">';
        html = html + '<h5 style="text-align: end;">' + data.idFecha.idActividad.idLugar.aulaLugar + '</h5>';
        html = html + '<p style="text-align: end;">' + data.idFecha.idActividad.idLugar.nombreLugar + '</p>';
        html = html + '</div>';
        html = html + '</div>';
        return html
    }

    var fechaInicioPeriodo, fechaFinPeriodo, fecha, hinicio, hfin, actividad;
    $('#dashboardDocente').on('click', '#trjActividad', function () {
        var clase = ($(this).attr('class')).split(' ');
        actividad = informacion[clase[0]][clase[1]];
        console.log(clase);

        if (actividad != undefined) {


            //Asignacion de titulos
            $('#myModal .modal-title').text(actividad.idFecha.idActividad.nombreActividad);
            if (actividad.estadoListadoFecha == "APLAZADA") {
                if (actividad.fechaAplazadaListadoFecha != clase[0]) {
                    $(".modalHeader").css("background-color", "#ffc107");
                    $('#myModal .modal-subtitle1').text(actividad.fechaListadoFecha);
                    $('#myModal .modal-subtitle2').text(actividad.horaInicioListadoFecha.slice(0, 5) + " / " + actividad.horaFinListadoFecha.slice(0, 5));
                    var f = (actividad.fechaAplazadaListadoFecha).split("-");
                    fecha = f[2] + '-' + f[1] + '-' + f[0];
                    hinicio = actividad.horaInicioAplazadaListadoFecha.slice(0, 5);
                    hfin = actividad.horaFinAplazadaListadoFecha.slice(0, 5);
                    $('#myModal .modalEstado').html(actividad.estadoListadoFecha + "<br>Fecha Nueva: " + fecha + "<br>Hora: De " + hinicio + " a " + hfin + ".<br><b>Motivo:</b> " + actividad.observacionListadoFecha);
                } else {
                    $(".modalHeader").css("background-color", "#28a745");
                    $('#myModal .modal-subtitle1').text(actividad.fechaAplazadaListadoFecha);
                    $('#myModal .modal-subtitle2').text(actividad.horaInicioAplazadaListadoFecha.slice(0, 5) + " / " + actividad.horaFinAplazadaListadoFecha.slice(0, 5));
                    var f = (actividad.fechaListadoFecha).split("-");
                    fecha = f[2] + '-' + f[1] + '-' + f[0];
                    hinicio = actividad.horaInicioListadoFecha.slice(0, 5);
                    hfin = actividad.horaFinListadoFecha.slice(0, 5);
                    $('#myModal .modalEstado').html("ACTIVA (Horario especial) <br>Fecha anterior: " + fecha + "<br>Hora anterior: De " + hinicio + " a " + hfin + ".<br><b>Motivo aplazamiento: </b> " + actividad.observacionListadoFecha);
                }


            } else {
                $('#myModal .modal-subtitle1').text(actividad.fechaListadoFecha);
                $('#myModal .modal-subtitle2').text(actividad.horaInicioListadoFecha.slice(0, 5) + " / " + actividad.horaFinListadoFecha.slice(0, 5));
            }

            //Asignacion de informacion dentro del modal

            $('#myModal .modalActividad').html(actividad.idFecha.idActividad.descripcionActividad);

            switch (actividad.idFecha.frecuenciaFecha) {
                case 'frecuenciaUnaVez':
                    $('#myModal .modalFrecuencia').html("Una sola vez<br>Día : " + actividad.idFecha.diaFecha + " (" + actividad.idFecha.fechaInicioFecha + ")<br> Hora asignada : " + actividad.idFecha.horaInicioFecha.slice(0, 5) + " / " + actividad.idFecha.horaFinFecha.slice(0, 5));
                    var fInicioPeriodo1 = (actividad.idFecha.idActividad.idPeriodo.fechaInicioPeriodo).split("-");
                    fechaInicioPeriodo = new Date(fInicioPeriodo1[0], fInicioPeriodo1[1] - 1, fInicioPeriodo1[2]);
                    var fFinPeriodo1 = (actividad.idFecha.idActividad.idPeriodo.fechaFinPeriodo).split("-");
                    fechaFinPeriodo = new Date(fFinPeriodo1[0], fFinPeriodo1[1] - 1, fFinPeriodo1[2]);
                    break;
                case 'frecuenciaUnaVezSemana':
                    $('#myModal .modalFrecuencia').html("Una vez a la semana<br>Día : " + actividad.idFecha.diaFecha + "<br>Fecha asignada : De " + actividad.idFecha.fechaInicioFecha + " a <br>" + actividad.idFecha.fechaFinFecha + "<br> Hora asignada : " + actividad.idFecha.horaInicioFecha.slice(0, 5) + " / " + actividad.idFecha.horaFinFecha.slice(0, 5));
                    var fInicioPeriodo1 = (actividad.idFecha.fechaInicioFecha).split("-");
                    fechaInicioPeriodo = new Date(fInicioPeriodo1[0], fInicioPeriodo1[1] - 1, fInicioPeriodo1[2]);
                    var fFinPeriodo1 = (actividad.idFecha.fechaFinFecha).split("-");
                    fechaFinPeriodo = new Date(fFinPeriodo1[0], fFinPeriodo1[1] - 1, fFinPeriodo1[2]);
                    break;
            }

            $('#myModal .modalPeriodo').html(actividad.idFecha.idActividad.idPeriodo.nombrePeriodo + "<br>" + actividad.idFecha.idActividad.idPeriodo.descripcionPeriodo + "<br>" + actividad.idFecha.idActividad.idPeriodo.fechaInicioPeriodo + " / " + actividad.idFecha.idActividad.idPeriodo.fechaFinPeriodo);

            if (actividad.estadoListadoFecha == "ACTIVA") {
                $(".modalHeader").css("background-color", "#28a745");
                $('#myModal .modalEstado').html(actividad.estadoListadoFecha);
            } else
                if (actividad.estadoListadoFecha == "APLAZADA") {


                } else
                    if (actividad.estadoListadoFecha == "CANCELADA") {
                        $(".modalHeader").css("background-color", "#f5f5f5");
                        $('#myModal .modalEstado').html(actividad.estadoListadoFecha + "<br><br><b>Motivo:</b> " + actividad.observacionListadoFecha);

                    }


            $('#myModal .modalRecursos').html("");
            if (actividad.idFecha.idActividad.idRecurso.length > 0) {
                $.each(actividad.idFecha.idActividad.idRecurso, function (key, value) {
                    $('#myModal .modalRecursos').append("<a href='" + value.urlRecurso + "' target='_blank' >" + value.nombreRecurso + "<hr>");
                });
            } else {
                $('#myModal .modalRecursos').html("Ninguno");
            }


        }

    });

});
