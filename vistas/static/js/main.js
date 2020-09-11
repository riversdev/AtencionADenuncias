let tipoNuevaDenuncia = "";
let presuntoDenuncia = ["presunto incumplimiento al código de ética.", "presunto incumplimiento a las reglas de integridad.", "presunto incumplimiento al código de conducta.", "presunta agresión.", "presunto amedrentamiento.", "presunta intimidación.", "presuntas amenazas."];
let cadPresuntoDenuncia = "";

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    prepararValidacionDeFormularios();
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
                    alertify.confirm('Guardando denuncia...', 'La información está incompleta y/o es incorrecta, si acepta se guardará como denuncia inconclusa y tendrá 3 dias para completarla en el menú "Denuncias".',
                        function () {
                            $("#txtStatusFormulario").val("inconclusa");
                            enviarDenuncia(recolectarDatosDenuncia(), "guardarInfo");
                        },
                        function () {
                            alertify.error('Cancelado')
                        }
                    );
                }
            } else {
                event.preventDefault();
                if (form.id == "formFormatoPresentacionDenuncia") {
                    $("#txtStatusFormulario").val("pendiente");
                    enviarDenuncia(recolectarDatosDenuncia(), "guardarInfo");
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
        cadPresuntoDenuncia = "Denuncia por " + presuntoDenuncia[presunto];
        $("#txtPresuntoDenuncia").html(cadPresuntoDenuncia);
        $("#txtFechaPresentacion").val(cadFechaActual);
        $("#inputPuesto").addClass("d-none");
        $("#inputEspecificar").addClass("d-none");
        $("#txtTareaFormulario").val("guardarInfo");
        $("#txtStatusFormulario").val("");
        $("#txtIdDenuncia").val("")
        $("#modalPresuntoDenuncia").modal("hide");
        $('#nav-nuevaDenunciaForm-tab').tab('show');
    } else if (tipoNuevaDenuncia == "subirImagen") {
        $("#modalPresuntoDenuncia").modal("hide");
        $('#nav-nuevaDenunciaImg-tab').tab('show');
    }
}

function recolectarDatosDenuncia() {
    return {
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
    $.ajax({
        type: "POST",
        url: "ajax/ajaxCrudDenuncias.php?accion=" + accion,
        data: {
            txtTareaFormulario: objDenuncia.txtTareaFormulario,
            txtStatusFormulario: objDenuncia.txtStatusFormulario,
            txtIdDenuncia: objDenuncia.txtIdDenuncia,
            txtTipoDenuncia: cadPresuntoDenuncia,
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
            let mensaje = data.split('|');
            if (mensaje[0] == "success") {
                $('#nav-denuncias-tab').tab('show');
                document.getElementById("formFormatoPresentacionDenuncia").reset();
                alertify.success(mensaje[1]);
            } else if (mensaje[0] == "error") {
                alertify.error(mensaje[1]);
            } else {
                console.log("Tipo de respuesta no definido. " + data);
            }
        }
    });
}

function obtenerDenuncias(tipoDenuncia) {
    $.ajax({
        type: "POST",
        url: "ajax/ajaxDenuncias.php",
        data: {
            tipoPeticion: "leer",
            tipoDenuncia
        },
        error: function (data) {
            console.error(data);
        },
        success: function (data) {
            $("#contenedor" + tipoDenuncia).empty();
            $("#contenedor" + tipoDenuncia).append(data);
        }
    });
}