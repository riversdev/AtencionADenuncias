let tipoNuevaDenuncia = "";
let presuntoDenuncia = ["presunto incumplimiento al código de ética.", "presunto incumplimiento a las reglas de integridad.", "presunto incumplimiento al código de conducta.", "presunta agresión.", "presunto amedrentamiento.", "presunta intimidación.", "presuntas amenazas."];
let cadPresuntoDenuncia = "";

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    prepararValidacionDeFormularios();
    enviarDenuncia(recolectarDatosDenuncia(), "leer");
    // BIENVENIDA A LA SESION
    alertify.success("Todo está listo!");
    // CERRAR SESION
    $('#salir').on('click', function () {
        $.ajax({
            type: "POST",
            url: "ajax/ajaxLogin.php",
            data: {
                tipoPeticion: "salir"
            },
            error: function (data) {
                console.error(data);
            },
            success: function (data) {
                location.href = "/AtencionADenuncias";
            }
        });
    });

    // PRESUNTO DE NUEVA DENUNCIA
    $('#llenarFormulario').on('click', function () {
        tipoNuevaDenuncia = "llenarFormulario";
        $("#modalPresuntoDenuncia").modal("show");
    });
    $('#subirImagen').on('click', function () {
        tipoNuevaDenuncia = "subirImagen";
        $("#modalPresuntoDenuncia").modal("show");
    });
    $('#presunto1').on('click', function () {
        prepararFormato(0);
    });
    $('#presunto2').on('click', function () {
        prepararFormato(1);
    });
    $('#presunto3').on('click', function () {
        prepararFormato(2);
    });
    $('#presunto4').on('click', function () {
        prepararFormato(3);
    });
    $('#presunto5').on('click', function () {
        prepararFormato(4);
    });
    $('#presunto6').on('click', function () {
        prepararFormato(5);
    });
    $('#presunto7').on('click', function () {
        prepararFormato(6);
    });

    // SERVIDOR PUBLICO ?
    $("#txtSPDenunciante").change(function () {
        let sp = $("#txtSPDenunciante").val();
        if (sp == "si") {
            $("#inputPuesto").removeClass("d-none");
            $("#inputEspecificar").addClass("d-none");
            $("#txtPuestoDenunciante").prop("required", true);
            $("#txtEspecificarDenunciante").prop("required", false);
        } else if (sp == "no") {
            $("#inputPuesto").addClass("d-none");
            $("#inputEspecificar").removeClass("d-none");
            $("#txtPuestoDenunciante").prop("required", false);
            $("#txtEspecificarDenunciante").prop("required", true);
        } else {
            console.log("Respuesta no definida");
        }
    });

    // TRABAJA EN ADMINISTRACION ?
    $("#txtTrabajaTestigo").change(function () {
        let ta = $("#txtTrabajaTestigo").val();
        if (ta == "si") {
            $("#inputED").removeClass("d-none");
            $("#inputCargo").removeClass("d-none");
            $("#txtEntidadTestigo").prop("required", true);
            $("#txtCargoTestigo").prop("required", true);
        } else if (ta == "no") {
            $("#inputED").addClass("d-none");
            $("#inputCargo").addClass("d-none");
            $("#txtEntidadTestigo").prop("required", false);
            $("#txtCargoTestigo").prop("required", false);
        } else {
            console.log("Respuesta no definida");
        }
    });

    // DENUNCIAS
    //obtenerDenuncias("inconclusas");
    //obtenerDenuncias("pendientes");
    //obtenerDenuncias("concluidas");
});

function prepararValidacionDeFormularios() {
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
                if (form.id == "formFormatoPresentacionDenuncia") {
                    if ($("#txtNumExpediente").val() == "") {
                        alertify.confirm('Guardando denuncia...', 'La información está incompleta y/o es incorrecta, si acepta se guardará como denuncia inconclusa y tendrá 3 dias para completarla en el menú "Denuncias".',
                            function () {
                                $("#txtStatusFormulario").val("inconclusa");
                                enviarDenuncia(recolectarDatosDenuncia(), "guardarInfo");
                            },
                            function () {
                                alertify.error('Cancelado')
                            }
                        );
                    } else {
                        alertify.confirm('Editando denuncia...', 'La información está incompleta y/o es incorrecta, si acepta se guardará como denuncia inconclusa y tendrá 3 dias a partir de su fecha de presentación para completarla en el menú "Denuncias".',
                            function () {
                                $("#txtStatusFormulario").val("inconclusa");
                                enviarDenuncia(recolectarDatosDenuncia(), "editarInfo");
                            },
                            function () {
                                alertify.error('Cancelado')
                            }
                        );
                    }
                }
            } else {
                event.preventDefault();
                if (form.id == "formFormatoPresentacionDenuncia") {
                    if ($("#txtNumExpediente").val() == "") {
                        $("#txtStatusFormulario").val("pendiente");
                        enviarDenuncia(recolectarDatosDenuncia(), "guardarInfo");
                    } else {
                        $("#txtStatusFormulario").val("pendiente");
                        enviarDenuncia(recolectarDatosDenuncia(), "editarInfo");
                    }
                }
            }
            form.classList.add('was-validated');
        }, false);
    });
}

function prepararFormato(presunto) {
    // FECHA ACTUAL RECUPERADA CON JS
    let fechaActual = new Date();
    let anio = fechaActual.getFullYear();
    let mes = fechaActual.getMonth() + 1;
    let dia = fechaActual.getDate();
    mes < 10 ? mes = '0' + mes : mes = mes;
    dia < 10 ? dia = '0' + dia : dia = dia;
    let cadFechaActual = anio + '-' + mes + '-' + dia;
    if (tipoNuevaDenuncia == "llenarFormulario") {
        // CONFIGURACIONES INICIALES DEL FORMULARIO FORMATO DE DENUNCIAS
        document.getElementById("formFormatoPresentacionDenuncia").reset();
        $("#contenedorNumExpediente").addClass("d-none");
        cadPresuntoDenuncia = "Denuncia por " + presuntoDenuncia[presunto];
        $("#txtPresuntoDenuncia").html(cadPresuntoDenuncia);
        $("#txtFechaPresentacion").val(cadFechaActual);
        $("#inputPuesto").addClass("d-none");
        $("#inputEspecificar").addClass("d-none");
        $("#txtTareaFormulario").val("guardarInfo");
        $("#modalPresuntoDenuncia").modal("hide");
        $('#nav-nuevaDenunciaForm-tab').tab('show');
    } else if (tipoNuevaDenuncia == "subirImagen") {
        $("#modalPresuntoDenuncia").modal("hide");
        $('#nav-nuevaDenunciaImg-tab').tab('show');
    }
}

function recolectarDatosDenuncia() {
    return {
        txtNumExpediente: $("#txtNumExpediente").val(),
        txtTareaFormulario: $("#txtTareaFormulario").val(),
        txtStatusFormulario: $("#txtStatusFormulario").val(),
        txtIdDenuncia: $("#txtIdDenuncia").val(),
        txtFechaPresentacion: $("#txtFechaPresentacion").val(),
        txtAnonimatoDenunciante: $("#txtAnonimatoDenunciante").val(),
        txtNombreDenunciante: $("#txtNombreDenunciante").val(),
        txtDomicilioDenunciante: $("#txtDomicilioDenunciante").val(),
        txtTelefonoDenunciante: $("#txtTelefonoDenunciante").val(),
        txtCorreoDenunciante: $("#txtCorreoDenunciante").val(),
        txtSexoDenunciante: $("#txtSexoDenunciante").val(),
        txtEdadDenunciante: $("#txtEdadDenunciante").val(),
        txtSPDenunciante: $("#txtSPDenunciante").val(),
        txtPuestoDenunciante: $("#txtPuestoDenunciante").val(),
        txtEspecificarDenunciante: $("#txtEspecificarDenunciante").val(),
        txtGradoEstudiosDenunciante: $("#txtGradoEstudiosDenunciante").val(),
        txtDiscapacidadDenunciante: $("#txtDiscapacidadDenunciante").val(),
        txtNombreDenunciado: $("#txtNombreDenunciado").val(),
        txtEntidadDenunciado: $("#txtEntidadDenunciado").val(),
        txtTelefonoDenunciado: $("#txtTelefonoDenunciado").val(),
        txtCorreoDenunciado: $("#txtCorreoDenunciado").val(),
        txtSexoDenunciado: $("#txtSexoDenunciado").val(),
        txtEdadDenunciado: $("#txtEdadDenunciado").val(),
        txtSPDenunciado: $("#txtSPDenunciado").val(),
        txtEspecificarDenunciado: $("#txtEspecificarDenunciado").val(),
        txtRelacionDenunciado: $("#txtRelacionDenunciado").val(),
        txtLugarDenuncia: $("#txtLugarDenuncia").val(),
        txtFechaDenuncia: $("#txtFechaDenuncia").val(),
        txtHoraDenuncia: $("#txtHoraDenuncia").val(),
        txtNarracionDenuncia: $("#txtNarracionDenuncia").val(),
        txtNombreTestigo: $("#txtNombreTestigo").val(),
        txtDomicilioTestigo: $("#txtDomicilioTestigo").val(),
        txtTelefonoTestigo: $("#txtTelefonoTestigo").val(),
        txtCorreoTestigo: $("#txtCorreoTestigo").val(),
        txtRelacionTestigo: $("#txtRelacionTestigo").val(),
        txtTrabajaTestigo: $("#txtTrabajaTestigo").val(),
        txtEntidadTestigo: $("#txtEntidadTestigo").val(),
        txtCargoTestigo: $("#txtCargoTestigo").val(),
    }
}

function enviarDenuncia(objDenuncia, accion) {
    let txtTipoDenuncia = "";
    if (accion == "guardarInfo") {
        txtTipoDenuncia = cadPresuntoDenuncia;
    } else {
        txtTipoDenuncia = $("#txtPresuntoDenuncia").html();
    }
    $.ajax({
        type: "POST",
        url: "ajax/ajaxCrudDenuncias.php?accion=" + accion,
        data: {
            txtNumExpediente: objDenuncia.txtNumExpediente,
            txtTareaFormulario: objDenuncia.txtTareaFormulario,
            txtStatusFormulario: objDenuncia.txtStatusFormulario,
            txtIdDenuncia: objDenuncia.txtIdDenuncia,
            txtTipoDenuncia: txtTipoDenuncia,
            txtFechaPresentacion: objDenuncia.txtFechaPresentacion,
            txtAnonimatoDenunciante: objDenuncia.txtAnonimatoDenunciante,
            txtNombreDenunciante: objDenuncia.txtNombreDenunciante,
            txtDomicilioDenunciante: objDenuncia.txtDomicilioDenunciante,
            txtTelefonoDenunciante: objDenuncia.txtTelefonoDenunciante,
            txtCorreoDenunciante: objDenuncia.txtCorreoDenunciante,
            txtSexoDenunciante: objDenuncia.txtSexoDenunciante,
            txtEdadDenunciante: objDenuncia.txtEdadDenunciante,
            txtSPDenunciante: objDenuncia.txtSPDenunciante,
            txtPuestoDenunciante: objDenuncia.txtPuestoDenunciante,
            txtEspecificarDenunciante: objDenuncia.txtEspecificarDenunciante,
            txtGradoEstudiosDenunciante: objDenuncia.txtGradoEstudiosDenunciante,
            txtDiscapacidadDenunciante: objDenuncia.txtDiscapacidadDenunciante,
            txtNombreDenunciado: objDenuncia.txtNombreDenunciado,
            txtEntidadDenunciado: objDenuncia.txtEntidadDenunciado,
            txtTelefonoDenunciado: objDenuncia.txtTelefonoDenunciado,
            txtCorreoDenunciado: objDenuncia.txtCorreoDenunciado,
            txtSexoDenunciado: objDenuncia.txtSexoDenunciado,
            txtEdadDenunciado: objDenuncia.txtEdadDenunciado,
            txtSPDenunciado: objDenuncia.txtSPDenunciado,
            txtEspecificarDenunciado: objDenuncia.txtEspecificarDenunciado,
            txtRelacionDenunciado: objDenuncia.txtRelacionDenunciado,
            txtLugarDenuncia: objDenuncia.txtLugarDenuncia,
            txtFechaDenuncia: objDenuncia.txtFechaDenuncia,
            txtHoraDenuncia: objDenuncia.txtHoraDenuncia,
            txtNarracionDenuncia: objDenuncia.txtNarracionDenuncia,
            txtNombreTestigo: objDenuncia.txtNombreTestigo,
            txtDomicilioTestigo: objDenuncia.txtDomicilioTestigo,
            txtTelefonoTestigo: objDenuncia.txtTelefonoTestigo,
            txtCorreoTestigo: objDenuncia.txtCorreoTestigo,
            txtRelacionTestigo: objDenuncia.txtRelacionTestigo,
            txtTrabajaTestigo: objDenuncia.txtTrabajaTestigo,
            txtEntidadTestigo: objDenuncia.txtEntidadTestigo,
            txtCargoTestigo: objDenuncia.txtCargoTestigo
        },
        error: function (data) {
            console.error("Error peticion ajax para enviar información de denuncia, DETALLES: " + data);
        },
        success: function (data) {
            if (accion == "leer") {
                $('#contenedorTablasDenuncias').empty();
                $('#contenedorTablasDenuncias').append(data);
                tabularDenuncias();
            } else if (accion == "guardarInfo" || accion == "editarInfo") {
                let mensaje = data.split('|');
                if (mensaje[0] == "success") {
                    document.getElementById("formFormatoPresentacionDenuncia").reset();
                    enviarDenuncia(recolectarDatosDenuncia(), "leer");
                    $('#nav-denuncias-tab').tab('show');
                    alertify.success(mensaje[1]);
                } else if (mensaje[0] == "error") {
                    alertify.error(mensaje[1]);
                } else {
                    console.log("Tipo de respuesta no definido. " + data);
                }
            }
        }
    });
}

function tabularDenuncias() {
    let tablaInconclusas = $("#tablaInconclusas").DataTable({
        //scrollX: true,
        columnDefs: [
            { targets: [0], visible: false, searchable: true },
            { targets: [1], visible: false, searchable: true },
            { targets: [2], visible: true, searchable: true },
            { targets: [3], visible: true, searchable: true },
            { targets: [4], visible: false, searchable: true },
            { targets: [5], visible: true, searchable: true },
            { targets: [6], visible: false, searchable: true },
            { targets: [7], visible: false, searchable: true },
            { targets: [8], visible: false, searchable: true },
            { targets: [9], visible: false, searchable: true },
            { targets: [10], visible: false, searchable: true },
            { targets: [11], visible: false, searchable: true },
            { targets: [12], visible: false, searchable: true },
            { targets: [13], visible: false, searchable: true },
            { targets: [14], visible: false, searchable: true },
            { targets: [15], visible: false, searchable: true },
            { targets: [16], visible: true, searchable: true },
            { targets: [17], visible: false, searchable: true },
            { targets: [18], visible: false, searchable: true },
            { targets: [19], visible: false, searchable: true },
            { targets: [20], visible: false, searchable: true },
            { targets: [21], visible: false, searchable: true },
            { targets: [22], visible: false, searchable: true },
            { targets: [23], visible: false, searchable: true },
            { targets: [24], visible: false, searchable: true },
            { targets: [25], visible: false, searchable: true },
            { targets: [26], visible: false, searchable: true },
            { targets: [27], visible: false, searchable: true },
            { targets: [28], visible: false, searchable: true },
            { targets: [29], visible: false, searchable: true },
            { targets: [30], visible: false, searchable: true },
            { targets: [31], visible: false, searchable: true },
            { targets: [32], visible: false, searchable: true },
            { targets: [33], visible: false, searchable: true },
            { targets: [34], visible: false, searchable: true },
            { targets: [35], visible: false, searchable: true },
            { targets: [36], visible: false, searchable: true },
            { targets: [37], visible: false, searchable: true },
            { targets: [38], visible: true, searchable: true }
        ],
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo:
                "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "Buscar:",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior"
            },
            aria: {
                SortAscending: ": Activar para ordenar la columna de manera ascendente",
                SortDescending:
                    ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
    let tablaPendientes = $("#tablaPendientes").DataTable({
        //scrollX: true,
        columnDefs: [
            { targets: [0], visible: false, searchable: true },
            { targets: [1], visible: false, searchable: true },
            { targets: [2], visible: true, searchable: true },
            { targets: [3], visible: true, searchable: true },
            { targets: [4], visible: false, searchable: true },
            { targets: [5], visible: true, searchable: true },
            { targets: [6], visible: false, searchable: true },
            { targets: [7], visible: false, searchable: true },
            { targets: [8], visible: false, searchable: true },
            { targets: [9], visible: false, searchable: true },
            { targets: [10], visible: false, searchable: true },
            { targets: [11], visible: false, searchable: true },
            { targets: [12], visible: false, searchable: true },
            { targets: [13], visible: false, searchable: true },
            { targets: [14], visible: false, searchable: true },
            { targets: [15], visible: false, searchable: true },
            { targets: [16], visible: true, searchable: true },
            { targets: [17], visible: false, searchable: true },
            { targets: [18], visible: false, searchable: true },
            { targets: [19], visible: false, searchable: true },
            { targets: [20], visible: false, searchable: true },
            { targets: [21], visible: false, searchable: true },
            { targets: [22], visible: false, searchable: true },
            { targets: [23], visible: false, searchable: true },
            { targets: [24], visible: false, searchable: true },
            { targets: [25], visible: false, searchable: true },
            { targets: [26], visible: false, searchable: true },
            { targets: [27], visible: false, searchable: true },
            { targets: [28], visible: false, searchable: true },
            { targets: [29], visible: false, searchable: true },
            { targets: [30], visible: false, searchable: true },
            { targets: [31], visible: false, searchable: true },
            { targets: [32], visible: false, searchable: true },
            { targets: [33], visible: false, searchable: true },
            { targets: [34], visible: false, searchable: true },
            { targets: [35], visible: false, searchable: true },
            { targets: [36], visible: false, searchable: true },
            { targets: [37], visible: false, searchable: true },
            { targets: [38], visible: true, searchable: true }
        ],
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo:
                "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "Buscar:",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior"
            },
            aria: {
                SortAscending: ": Activar para ordenar la columna de manera ascendente",
                SortDescending:
                    ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
    let tablaConcluidas = $("#tablaConcluidas").DataTable({
        //scrollX: true,
        columnDefs: [
            { targets: [0], visible: false, searchable: true },
            { targets: [1], visible: false, searchable: true },
            { targets: [2], visible: true, searchable: true },
            { targets: [3], visible: true, searchable: true },
            { targets: [4], visible: false, searchable: true },
            { targets: [5], visible: true, searchable: true },
            { targets: [6], visible: false, searchable: true },
            { targets: [7], visible: false, searchable: true },
            { targets: [8], visible: false, searchable: true },
            { targets: [9], visible: false, searchable: true },
            { targets: [10], visible: false, searchable: true },
            { targets: [11], visible: false, searchable: true },
            { targets: [12], visible: false, searchable: true },
            { targets: [13], visible: false, searchable: true },
            { targets: [14], visible: false, searchable: true },
            { targets: [15], visible: false, searchable: true },
            { targets: [16], visible: true, searchable: true },
            { targets: [17], visible: false, searchable: true },
            { targets: [18], visible: false, searchable: true },
            { targets: [19], visible: false, searchable: true },
            { targets: [20], visible: false, searchable: true },
            { targets: [21], visible: false, searchable: true },
            { targets: [22], visible: false, searchable: true },
            { targets: [23], visible: false, searchable: true },
            { targets: [24], visible: false, searchable: true },
            { targets: [25], visible: false, searchable: true },
            { targets: [26], visible: false, searchable: true },
            { targets: [27], visible: false, searchable: true },
            { targets: [28], visible: false, searchable: true },
            { targets: [29], visible: false, searchable: true },
            { targets: [30], visible: false, searchable: true },
            { targets: [31], visible: false, searchable: true },
            { targets: [32], visible: false, searchable: true },
            { targets: [33], visible: false, searchable: true },
            { targets: [34], visible: false, searchable: true },
            { targets: [35], visible: false, searchable: true },
            { targets: [36], visible: false, searchable: true },
            { targets: [37], visible: false, searchable: true },
            { targets: [38], visible: true, searchable: true }
        ],
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo:
                "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "Buscar:",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior"
            },
            aria: {
                SortAscending: ": Activar para ordenar la columna de manera ascendente",
                SortDescending:
                    ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
    // tablaInconclusas.columns.adjust();
    // tablaPendientes.columns.adjust().draw();
    // tablaConcluidas.columns.adjust().draw();
}

function prepararParaEditar(idDenuncia, tipoDenuncia, numExpediente, fechaPresentacion, anonimatoDenunciante, nombreDenunciante, domicilioDenunciante, telefonoDenunciante, correoDenunciante, sexoDenunciante, edadDenunciante, servidorPublicoDenunciante, puestoDenunciante, especificarDenunciante, gradoEstudiosDenunciante, discapacidadDenunciante, nombreDenunciado, entidadDenunciado, telefonoDenunciado, correoDenunciado, sexoDenunciado, edadDenunciado, servidorPublicoDenunciado, especificarDenunciado, relacionDenunciado, lugarDenuncia, fechaDenuncia, horaDenuncia, narracionDenuncia, nombreTestigo, domicilioTestigo, telefonoTestigo, correoTestigo, relacionTestigo, trabajaTestigo, entidadTestigo, cargoTestigo, statusDenuncia,
) {
    $("#txtNumExpediente").val(numExpediente);
    $("#contenedorNumExpediente").removeClass("d-none");
    $("#txtTareaFormulario").val("editarInfo");
    $("#txtStatusFormulario").val(statusDenuncia);
    $("#txtIdDenuncia").val(idDenuncia);
    $("#txtPresuntoDenuncia").html(tipoDenuncia);
    $("#txtFechaPresentacion").val(fechaPresentacion);
    $("#txtAnonimatoDenunciante").val(anonimatoDenunciante);
    $("#txtNombreDenunciante").val(nombreDenunciante);
    $("#txtDomicilioDenunciante").val(domicilioDenunciante);
    $("#txtTelefonoDenunciante").val(telefonoDenunciante);
    $("#txtCorreoDenunciante").val(correoDenunciante);
    $("#txtSexoDenunciante").val(sexoDenunciante);
    $("#txtEdadDenunciante").val(edadDenunciante);
    $("#txtSPDenunciante").val(servidorPublicoDenunciante);
    if (servidorPublicoDenunciante == "si") {
        $("#inputPuesto").removeClass("d-none");
        $("#inputEspecificar").addClass("d-none");
        $("#txtPuestoDenunciante").prop("required", true);
        $("#txtEspecificarDenunciante").prop("required", false);
    } else if (servidorPublicoDenunciante == "no") {
        $("#inputPuesto").addClass("d-none");
        $("#inputEspecificar").removeClass("d-none");
        $("#txtPuestoDenunciante").prop("required", false);
        $("#txtEspecificarDenunciante").prop("required", true);
    } else {
        $("#inputPuesto").addClass("d-none");
        $("#inputEspecificar").addClass("d-none");
    }
    $("#txtPuestoDenunciante").val(puestoDenunciante);
    $("#txtEspecificarDenunciante").val(especificarDenunciante);
    $("#txtGradoEstudiosDenunciante").val(gradoEstudiosDenunciante);
    $("#txtDiscapacidadDenunciante").val(discapacidadDenunciante);
    $("#txtNombreDenunciado").val(nombreDenunciado);
    $("#txtEntidadDenunciado").val(entidadDenunciado);
    $("#txtTelefonoDenunciado").val(telefonoDenunciado);
    $("#txtCorreoDenunciado").val(correoDenunciado);
    $("#txtSexoDenunciado").val(sexoDenunciado);
    $("#txtEdadDenunciado").val(edadDenunciado);
    $("#txtSPDenunciado").val(servidorPublicoDenunciado);
    $("#txtEspecificarDenunciado").val(especificarDenunciado);
    $("#txtRelacionDenunciado").val(relacionDenunciado);
    $("#txtLugarDenuncia").val(lugarDenuncia);
    $("#txtFechaDenuncia").val(fechaDenuncia);
    $("#txtHoraDenuncia").val(horaDenuncia);
    $("#txtNarracionDenuncia").val(narracionDenuncia);
    $("#txtNombreTestigo").val(nombreTestigo);
    $("#txtDomicilioTestigo").val(domicilioTestigo);
    $("#txtTelefonoTestigo").val(telefonoTestigo);
    $("#txtCorreoTestigo").val(correoTestigo);
    $("#txtRelacionTestigo").val(relacionTestigo);
    $("#txtTrabajaTestigo").val(trabajaTestigo);
    if (trabajaTestigo == "si") {
        $("#inputED").removeClass("d-none");
        $("#inputCargo").removeClass("d-none");
        $("#txtEntidadTestigo").prop("required", true);
        $("#txtCargoTestigo").prop("required", true);
    } else if (trabajaTestigo == "no") {
        $("#inputED").addClass("d-none");
        $("#inputCargo").addClass("d-none");
        $("#txtEntidadTestigo").prop("required", false);
        $("#txtCargoTestigo").prop("required", false);
    } else {
        $("#inputED").addClass("d-none");
        $("#inputCargo").addClass("d-none");
    }
    $("#txtEntidadTestigo").val(entidadTestigo);
    $("#txtCargoTestigo").val(cargoTestigo);
    $("#txtTareaFormulario").val("editarInfo");
    $('#nav-nuevaDenunciaForm-tab').tab('show');
}