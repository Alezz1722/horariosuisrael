
$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var _result = "";

    $("#submitFormPeriodo").click(function () {
        $('.tablaExcel tbody').html("");
        $(".conjuntoExcel").attr("hidden", true);

        if (($(".idPeriodo").val() != "") && (analizaExcel() == 0)) {
            $(".conjuntoExcel").attr("hidden", true);
            var tr = "";

            $.when(
                $.each(_result, function (key, value) {
                    tr = tr + '<tr>';
                    tr = tr + '<td>';
                    tr = tr + (key + 1);
                    tr = tr + '</td>';
                    tr = tr + '<td>';
                    tr = tr + value.DIA;
                    tr = tr + '</td>';
                    tr = tr + '<td>';
                    tr = tr + value.HORA;
                    tr = tr + '</td>';
                    tr = tr + '<td>';
                    tr = tr + value.MATERIA;
                    tr = tr + '</td>';
                    tr = tr + '<td>';
                    tr = tr + value.AULA;
                    tr = tr + '</td>';
                    tr = tr + '<td>';
                    tr = tr + value.LUGAR;
                    tr = tr + '</td>';
                    tr = tr + '<tr>';
                })
            ).done(function (done) {
                $('.tablaExcel tbody').html(tr);
                $(".conjuntoExcel").attr("hidden", false);
            });


        } else {
            if (_result == "" || $(".idPeriodo").val() == "") {
                swal({
                    title: "Error",
                    text: "Por favor selecciona el periodo y/o carga el archivo excel",
                    icon: "error",
                    type: "error"
                })
            } else {
                swal({
                    title: "Error",
                    text: "Por favor revisa el archivo Excel, ya que no cumple con el formato establecido",
                    icon: "error",
                    type: "error"
                })
            }
        }
    })

    $("#enviaData").click(function () {
        swal({
            title: "Confirmación de importación",
            text: "Esta seguro de registrar las actividades de archivo Excel anteriormente detalladas ? ",
            icon: "warning",
            buttons: [
                'Cancelar',
                'Importar actividades'
            ],
        }).then(function (isConfirm) {
            if (isConfirm) {
                console.log({ actividades: _result, idperiodo: $(".idPeriodo").val() })
                $.ajax({
                    url: '/docente/importarExcel/crear/',
                    type: 'POST',
                    dataType: 'JSON',
                    data: { actividades: _result, idperiodo: $(".idPeriodo").val() },
                    success: function (data) {
                        console.log(data);
                        /**
                        if (data.success) {
                            $('.alert-danger').hide();
                            swal({
                                title: "Horario editado",
                                text: "El estado del horario fue asignado exitosamente!",
                                icon: "success",
                                type: "success"
                            }).then(function () {
                                obtieneInformacion();
                            }
                            );
                        }
                        */
                    }
                });
            }

        })
    })


    function analizaExcel() {
        var cont = 0, dias = {};
        if (_result !== '') {
            $.each(_result, function (key, value) {
                //Se encuentra declarado
                if (typeof value.DIA === 'undefined' ||
                    typeof value.AULA === 'undefined' ||
                    typeof value.HORA === 'undefined' ||
                    typeof value.LUGAR === 'undefined' ||
                    typeof value.MATERIA === 'undefined'
                ) {
                    cont++;
                } else {

                    //Validacion dias de la semana
                    if (!(
                        value.DIA == 'LUNES' ||
                        value.DIA == 'MARTES' ||
                        value.DIA == 'MIERCOLES' ||
                        value.DIA == 'JUEVES' ||
                        value.DIA == 'VIERNES' ||
                        value.DIA == 'SABADO' ||
                        value.DIA == 'DOMINGO'
                    )) {
                        cont++;
                    }

                    //Validacion horas

                    var horas = (value.HORA).split(" ");
                    if ((typeof horas[0] != 'undefined') && (typeof horas[1] != 'undefined')) {
                        if (!validateHhMm(horas[0]) || !validateHhMm(horas[1])) {
                            cont++;
                        }
                    } else {
                        cont++;
                    }
                }
            });
        } else {
            cont++;
        }


        return cont;
    }

    function validateHhMm(inputField) {
        var isValid = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(inputField);
        return isValid;
    }


    var _result;
    //Para subir archivos excel
    function handleFile(e) {
        //Get the files from Upload control
        _result = undefined;
        var files = e.target.files;
        var i, f;
        //Loop through files
        for (i = 0, f = files[i]; i != files.length; ++i) {
            var reader = new FileReader();
            var name = f.name;
            reader.onload = function (e) {
                var data = e.target.result;
                var workbook = XLSX.read(data, { type: 'binary' });
                var sheet_name_list = workbook.SheetNames;
                sheet_name_list.forEach(function (y) { /* iterate through sheets */
                    //Convert the cell value to Json
                    var roa = XLSX.utils.sheet_to_json(workbook.Sheets[y]);
                    if (roa.length > 0) {
                        _result = roa;
                    }
                });
            };
            reader.readAsArrayBuffer(f);
        }
    }

    $('#inputImportaExcel').change(handleFile);



});
