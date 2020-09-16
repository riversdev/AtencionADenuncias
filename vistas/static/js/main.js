let tipoNuevaDenuncia = "";
let presuntoDenuncia = ["presunto incumplimiento al código de ética.", "presunto incumplimiento a las reglas de integridad.", "presunto incumplimiento al código de conducta.", "presunta agresión.", "presunto amedrentamiento.", "presunta intimidación.", "presuntas amenazas."];
let cadPresuntoDenuncia = "";
// FECHA ACTUAL RECUPERADA CON JS
let fechaActual = new Date();
let anio = fechaActual.getFullYear();
let mes = fechaActual.getMonth() + 1;
let dia = fechaActual.getDate();
mes < 10 ? mes = '0' + mes : mes = mes;
dia < 10 ? dia = '0' + dia : dia = dia;
let cadFechaActual = anio + '-' + mes + '-' + dia;

$(document).ready(function () {
    // VALIDACIONES Y PREPARACIONES INICIALES
    $('#txtFechaDenuncia').attr("max", cadFechaActual);
    enviarDenuncia(recolectarDatosDenuncia(), "leer");
    prepararValidacionDeFormularios();
    // Label de input file
    $('.custom-file-input').on('change', function (event) {
        var inputFile = event.currentTarget;
        if (inputFile.files[0] != undefined) {
            $(inputFile).parent()
                .find('.custom-file-label')
                .html(inputFile.files[0].name);
        } else {
            $(inputFile).parent()
                .find('.custom-file-label')
                .html("Elegir imagen...");
        }
    });
    // Previzualizar imagen
    if ($("#txtImagenDenuncia").val() != undefined) {
        document.getElementById("txtImagenDenuncia").onchange = function (e) {
            if (e.target.files[0] != undefined) {
                let reader = new FileReader();
                reader.readAsDataURL(e.target.files[0]);
                reader.onload = function () {
                    let contenedorImagen = document.getElementById('contenedorImagen');
                    let image = document.createElement('img');
                    image.src = reader.result;
                    image.style = "height: 30vh; max-width: 27rem;";
                    contenedorImagen.innerHTML = '';
                    contenedorImagen.append(image);
                };
            } else {
                $("#contenedorImagen").empty();
            }
        }
    }
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

    // IMPRIMIR
    $('#btnImprimir').on('click', function () {
        //var restorePage = document.body.innerHTML;
        //var printContent = document.getElementById("formatoDenuncia").innerHTML;
        //document.body.innerHTML = printContent;
        window.print();
        //document.body.innerHTML = restorePage;
    });

    // MOSTRANDO Y OCULTANDO BOTON DE IMPRIMIR
    $('#nav-vizualizador-tab').on('shown.bs.tab', function (e) {
        $('#btnImprimir').removeClass('d-none');
        $('#navTipoDenuncia').removeClass('d-none');
        document.body.style.backgroundColor = "white";
    });
    $('#nav-vizualizador-tab').on('hidden.bs.tab', function (e) {
        $('#btnImprimir').addClass('d-none');
        $('#navTipoDenuncia').addClass('d-none');
        document.body.style.backgroundColor = "#F0F4F7";
    });

    // ACTIVE MANUAL NAVBAR
    $('#nav-denuncias-tab').on('shown.bs.tab', function (e) {
        $('#nav-denuncias-tab').addClass('text-white');
        $('#nav-denuncias-tab').removeClass('text-secondary');
    });
    $('#nav-denuncias-tab').on('hidden.bs.tab', function (e) {
        $('#nav-denuncias-tab').addClass('text-secondary');
        $('#nav-denuncias-tab').removeClass('text-white');
    });
});

function prepararValidacionDeFormularios() {
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
                if (form.id == "formFormatoPresentacionDenuncia") {
                    if ($("#txtIdDenuncia").val() == "") {
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
                    if ($("#txtIdDenuncia").val() == "") {
                        $("#txtStatusFormulario").val("pendiente");
                        enviarDenuncia(recolectarDatosDenuncia(), "guardarInfo");
                    } else {
                        $("#txtStatusFormulario").val("pendiente");
                        enviarDenuncia(recolectarDatosDenuncia(), "editarInfo");
                    }
                } else if (form.id == "formImgFormatoPresentacionDenuncia") {
                    if ($("#txtImagenIdDenuncia").val() == "") {
                        enviarImagenDenuncia(form.id, "guardarImg");
                    } else {
                        enviarImagenDenuncia(form.id, "editarImg");
                    }
                }
            }
            form.classList.add('was-validated');
        }, false);
    });
}

function prepararFormato(presunto) {
    if (tipoNuevaDenuncia == "llenarFormulario") {
        // CONFIGURACIONES INICIALES DEL FORMULARIO FORMATO DE DENUNCIAS
        document.getElementById("formFormatoPresentacionDenuncia").reset();
        $("#txtIdDenuncia").val("");
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
        document.getElementById("formImgFormatoPresentacionDenuncia").reset();
        $("#txtImagenIdDenuncia").val("");
        $("#contenedorNumExpedienteImg").addClass("d-none");
        $("#txtImagenDenuncia").prop("required", true);
        cadPresuntoDenuncia = "Denuncia por " + presuntoDenuncia[presunto];
        $("#txtImagenPresuntoDenuncia").html(cadPresuntoDenuncia);
        $("#txtImagenFechaPresentacion").val(cadFechaActual);
        $("#txtImagenFechaPresentacionV").val(cadFechaActual);
        $("#labelImgDenuncia").html("Elegir imagen...");
        $("#contenedorImagen").empty();
        $("#modalPresuntoDenuncia").modal("hide");
        $('#nav-nuevaDenunciaImg-tab').tab('show');
    } else if (tipoNuevaDenuncia == "editarInfo") {
        cadPresuntoDenuncia = "Denuncia por " + presuntoDenuncia[presunto];
        $("#txtPresuntoDenuncia").html(cadPresuntoDenuncia);
        $("#modalPresuntoDenuncia").modal("hide");
    } else if (tipoNuevaDenuncia == "editarImg") {
        cadPresuntoDenuncia = "Denuncia por " + presuntoDenuncia[presunto];
        $("#txtImagenPresuntoDenuncia").html(cadPresuntoDenuncia);
        $("#modalPresuntoDenuncia").modal("hide");
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
            } else if (accion == "guardarInfo" || accion == "editarInfo" || accion == "concluirDenuncia") {
                let mensaje = data.split('|');
                if (mensaje[0] == "success") {
                    document.getElementById("formFormatoPresentacionDenuncia").reset();
                    enviarDenuncia(recolectarDatosDenuncia(), "leer");
                    $('#nav-denuncias-tab').tab('show');
                    alertify.success(mensaje[1]);
                } else if (mensaje[0] == "error") {
                    alertify.error(mensaje[1]);
                    if (mensaje[2]) {
                        console.log(mensaje[2]);
                    }
                } else {
                    console.log("Tipo de respuesta no definido. " + data);
                }
            }
        }
    });
}

function enviarImagenDenuncia(form, accion) {
    if (accion == "guardarImg") {
        $("#txtImagenPresunto").val(cadPresuntoDenuncia);
    } else {
        $("#txtImagenPresunto").val($("#txtImagenPresuntoDenuncia").html());
    }
    var formData = new FormData(document.getElementById(form));
    $.ajax({
        type: "POST",
        url: "ajax/ajaxCrudDenuncias.php?accion=" + accion,
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    }).done(function (data) {
        let mensaje = data.split('|');
        if (mensaje[0] == 'success') {
            document.getElementById("formImgFormatoPresentacionDenuncia").reset();
            enviarDenuncia(recolectarDatosDenuncia(), "leer");
            $('#nav-denuncias-tab').tab('show');
            alertify.success(mensaje[1]);
        } else if (mensaje[0] == 'error') {
            alertify.error(mensaje[1]);
            if (mensaje[2]) {
                console.log(mensaje[2]);
            }
        } else {
            console.log("Tipo de respuesta no definido. " + data);
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

function prepararParaEditar(idDenuncia, tipoDenuncia, numExpediente, fechaPresentacion, imagenDenuncia, anonimatoDenunciante, nombreDenunciante, domicilioDenunciante, telefonoDenunciante, correoDenunciante, sexoDenunciante, edadDenunciante, servidorPublicoDenunciante, puestoDenunciante, especificarDenunciante, gradoEstudiosDenunciante, discapacidadDenunciante, nombreDenunciado, entidadDenunciado, telefonoDenunciado, correoDenunciado, sexoDenunciado, edadDenunciado, servidorPublicoDenunciado, especificarDenunciado, relacionDenunciado, lugarDenuncia, fechaDenuncia, horaDenuncia, narracionDenuncia, nombreTestigo, domicilioTestigo, telefonoTestigo, correoTestigo, relacionTestigo, trabajaTestigo, entidadTestigo, cargoTestigo, statusDenuncia) {
    if (imagenDenuncia != "") {
        tipoNuevaDenuncia = "editarImg";
        $("#txtImagenDenuncia").prop("required", false);
        $("#contenedorNumExpedienteImg").removeClass("d-none");
        $("#txtImagenIdDenuncia").val(idDenuncia);
        $("#txtImagenPresunto").val(tipoDenuncia);
        $("#txtImagenPresuntoDenuncia").html(tipoDenuncia);
        $("#txtImagenNumExpediente").val(numExpediente);
        $("#txtImagenNumExpedienteV").val(numExpediente);
        $("#txtImagenFechaPresentacion").val(fechaPresentacion);
        $("#txtImagenFechaPresentacionV").val(fechaPresentacion);
        $("#labelImgDenuncia").html("Elegir imagen...");
        let contenedorImagen = document.getElementById('contenedorImagen');
        let image = document.createElement('img');
        image.src = "data:image/jpeg;base64," + imagenDenuncia;
        image.style = "height: 30vh; max-width: 27rem;";
        contenedorImagen.innerHTML = '';
        contenedorImagen.append(image);
        $('#nav-nuevaDenunciaImg-tab').tab('show');
    } else {
        tipoNuevaDenuncia = "editarInfo";
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
}

function prepararParaVizualizar(tipoDenuncia, numExpediente, fechaPresentacion, imagenDenuncia, anonimatoDenunciante, nombreDenunciante, domicilioDenunciante, telefonoDenunciante, correoDenunciante, sexoDenunciante, edadDenunciante, servidorPublicoDenunciante, puestoDenunciante, especificarDenunciante, gradoEstudiosDenunciante, discapacidadDenunciante, nombreDenunciado, entidadDenunciado, telefonoDenunciado, correoDenunciado, sexoDenunciado, edadDenunciado, servidorPublicoDenunciado, especificarDenunciado, relacionDenunciado, lugarDenuncia, fechaDenuncia, horaDenuncia, narracionDenuncia, nombreTestigo, domicilioTestigo, telefonoTestigo, correoTestigo, relacionTestigo, trabajaTestigo, entidadTestigo, cargoTestigo, statusDenuncia) {
    if (imagenDenuncia != "") {
        $("#contenedorImagenGeneral").removeClass("d-none");
        $("#contenedorDatosGenerales").addClass("d-none");
        let contenedorImagenFormato = document.getElementById('contenedorImagenFormato');
        let image = document.createElement('img');
        image.src = "data:image/jpeg;base64," + imagenDenuncia;
        image.style = "width: 100vh";
        image.class = "border";
        contenedorImagenFormato.innerHTML = '';
        contenedorImagenFormato.append(image);
    } else {
        $("#contenedorDatosGenerales").removeClass("d-none");
        $("#contenedorImagenGeneral").addClass("d-none");
    }
    $("#txtPresuntoDenunciaV").html(tipoDenuncia);
    $("#txtNumExpedienteV").val(numExpediente);
    $("#txtFechaPresentacionV").val(fechaPresentacion);
    $("#txtAnonimatoDenuncianteV").val(anonimatoDenunciante);
    $("#txtNombreDenuncianteV").val(nombreDenunciante);
    $("#txtDomicilioDenuncianteV").val(domicilioDenunciante);
    $("#txtTelefonoDenuncianteV").val(telefonoDenunciante);
    $("#txtCorreoDenuncianteV").val(correoDenunciante);
    $("#txtSexoDenuncianteV").val(sexoDenunciante);
    $("#txtEdadDenuncianteV").val(edadDenunciante);
    $("#txtSPDenuncianteV").val(servidorPublicoDenunciante);
    if (servidorPublicoDenunciante == "si") {
        $("#inputPuestoV").removeClass("d-none");
        $("#inputEspecificarV").addClass("d-none");
    } else if (servidorPublicoDenunciante == "no") {
        $("#inputPuestoV").addClass("d-none");
        $("#inputEspecificarV").removeClass("d-none");
    } else {
        $("#inputPuestoV").addClass("d-none");
        $("#inputEspecificarV").addClass("d-none");
    }
    $("#txtPuestoDenuncianteV").val(puestoDenunciante);
    $("#txtEspecificarDenuncianteV").val(especificarDenunciante);
    $("#txtGradoEstudiosDenuncianteV").val(gradoEstudiosDenunciante);
    $("#txtDiscapacidadDenuncianteV").val(discapacidadDenunciante);
    $("#txtNombreDenunciadoV").val(nombreDenunciado);
    $("#txtEntidadDenunciadoV").val(entidadDenunciado);
    $("#txtTelefonoDenunciadoV").val(telefonoDenunciado);
    $("#txtCorreoDenunciadoV").val(correoDenunciado);
    $("#txtSexoDenunciadoV").val(sexoDenunciado);
    $("#txtEdadDenunciadoV").val(edadDenunciado);
    $("#txtSPDenunciadoV").val(servidorPublicoDenunciado);
    $("#txtEspecificarDenunciadoV").val(especificarDenunciado);
    $("#txtRelacionDenunciadoV").val(relacionDenunciado);
    $("#txtLugarDenunciaV").val(lugarDenuncia);
    $("#txtFechaDenunciaV").val(fechaDenuncia);
    $("#txtHoraDenunciaV").val(horaDenuncia);
    $("#txtNarracionDenunciaV").val(narracionDenuncia);
    $("#txtNombreTestigoV").val(nombreTestigo);
    $("#txtDomicilioTestigoV").val(domicilioTestigo);
    $("#txtTelefonoTestigoV").val(telefonoTestigo);
    $("#txtCorreoTestigoV").val(correoTestigo);
    $("#txtRelacionTestigoV").val(relacionTestigo);
    $("#txtTrabajaTestigoV").val(trabajaTestigo);
    if (trabajaTestigo == "si") {
        $("#inputEDV").removeClass("d-none");
        $("#inputCargoV").removeClass("d-none");
    } else if (trabajaTestigo == "no") {
        $("#inputEDV").addClass("d-none");
        $("#inputCargoV").addClass("d-none");
    } else {
        $("#inputEDV").addClass("d-none");
        $("#inputCargoV").addClass("d-none");
    }
    $("#txtEntidadTestigoV").val(entidadTestigo);
    $("#txtCargoTestigoV").val(cargoTestigo);
    $('#nav-vizualizador-tab').tab('show');
}

function prepararParaConcluir(idDenuncia, denunciante, denunciado, tipoDenuncia) {
    alertify.confirm('Concluyendo denuncia...', '¿Está seguro de que querer concluir con la denuncia de ' + denunciante + ' para ' + denunciado + '? <br><br>Tipo de denuncia: ' + tipoDenuncia,
        function () {
            $("#txtIdDenuncia").val(idDenuncia);
            enviarDenuncia(recolectarDatosDenuncia(), "concluirDenuncia");
        },
        function () {
            alertify.error('Cancelado')
        }
    );
}