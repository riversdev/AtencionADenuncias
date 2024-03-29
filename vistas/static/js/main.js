let tipoNuevaDenuncia = "";
let presuntoDenuncia = ["presunto incumplimiento al código de ética y de conducta.", "presunto incumplimiento a las reglas de integridad.", "presunta agresión.", "presunto amedrentamiento.", "presunta intimidación.", "presuntas amenazas."];
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
    $('[data-toggle="popover"]').popover();
    $('[data-toggle="tooltip"]').tooltip();
    $('#txtFechaDenuncia').attr("max", cadFechaActual);
    prepararValidacionDeFormularios();
    // Diseño de alertas
    alertify.defaults.transition = "flipy";
    alertify.defaults.theme.ok = "btn btn-sm btn-transparent";
    alertify.defaults.theme.cancel = "btn btn-sm btn-transparent text-danger";
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

    // PREVIZUALIZAR IMAGEN
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

    // PREVIZUALIZAR PDF
    if ($("#txtDenunciaPDF").val() != undefined) {
        document.getElementById("txtDenunciaPDF").onchange = function (e) {
            if (e.target.files[0] != undefined) {
                let reader = new FileReader();
                reader.readAsDataURL(e.target.files[0]);
                reader.onload = function () {
                    let contenedorPDF = document.getElementById('contenedorPDF');
                    let pdf = document.createElement('object');
                    pdf.data = reader.result;
                    pdf.type = "application/pdf";
                    pdf.style = "height: 40vh; width: 80vh;";
                    contenedorPDF.innerHTML = '';
                    contenedorPDF.append(pdf);
                };
            } else {
                $("#contenedorPDF").empty();
            }
        }
    }

    // PREVIZUALIZAR ACTA PDF
    if ($("#txtActaDenunciaPDF").val() != undefined) {
        document.getElementById("txtActaDenunciaPDF").onchange = function (e) {
            if (e.target.files[0] != undefined) {
                let reader = new FileReader();
                reader.readAsDataURL(e.target.files[0]);
                reader.onload = function () {
                    let contenedorActaPDF = document.getElementById('contenedorActaPDF');
                    let pdf = document.createElement('object');
                    pdf.data = reader.result;
                    pdf.type = "application/pdf";
                    pdf.style = "height: 30vh; width: 60vh;";
                    contenedorActaPDF.innerHTML = '';
                    contenedorActaPDF.append(pdf);
                };
            } else {
                $("#contenedorActaPDF").empty();
            }
        }
    }

    // CERRAR SESION
    $('#salir').on('click', function () {
        salir();
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
    $('#subirPDF').on('click', function () {
        tipoNuevaDenuncia = "subirPDF";
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

    // MOSTRAR INPUTS DENUNCIANTE
    if (document.getElementById("mostrarInfoDenunciante") != null) {
        document.getElementById("mostrarInfoDenunciante").addEventListener('change', (event) => {
            if (document.getElementById("mostrarInfoDenunciante").checked) {
                document.getElementById("contenedorInformacionDenunciante").classList.remove("d-none");
                requerirCamposDenunciante();
                document.getElementById("txtSPDenunciante").value = "";
                document.getElementById("inputPuesto").classList.add("d-none");
                document.getElementById("inputEspecificar").classList.add("d-none");
            } else {
                document.getElementById("contenedorInformacionDenunciante").classList.add("d-none");
                noRequerirCamposDenunciante();
            }
        });
    }

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
        if (!window.print()) {
            alertify.warning('Oprima "control + p" en su teclado')
        }
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
    $('#nav-acuse-tab').on('shown.bs.tab', function (e) {
        $('#btnImprimir').removeClass('d-none');
        $('#navTipoDenuncia').removeClass('d-none');
        document.body.style.backgroundColor = "white";
    });
    $('#nav-acuse-tab').on('hidden.bs.tab', function (e) {
        $('#btnImprimir').addClass('d-none');
        $('#navTipoDenuncia').addClass('d-none');
        document.body.style.backgroundColor = "#F0F4F7";
    });

    // MOSTRANDO Y OCULTANDO BOTON DE AGREGAR USUARIO
    $('#nav-adminuser-tab').on('shown.bs.tab', function (e) {
        $('#btnAgregarUsuario').removeClass('d-none');
    });
    $('#nav-adminuser-tab').on('hidden.bs.tab', function (e) {
        $('#btnAgregarUsuario').addClass('d-none');
    });

    // ACTIVE MANUAL NAVBAR
    $('#nav-denuncias-tab').on('shown.bs.tab', function (e) {
        $('#nav-denuncias-tab').addClass('text-white');
        $('#nav-denuncias-tab').removeClass('text-secondary');
        $('#nav-adminuser-tab').addClass('text-secondary');
        $('#nav-adminuser-tab').removeClass('text-white');
        $('#opcionDenuncia').addClass('text-secondary');
        $('#opcionDenuncia').removeClass('text-white');
    });
    $('#nav-adminuser-tab').on('shown.bs.tab', function (e) {
        $('#nav-denuncias-tab').addClass('text-secondary');
        $('#nav-denuncias-tab').removeClass('text-white');
        $('#nav-adminuser-tab').addClass('text-white');
        $('#nav-adminuser-tab').removeClass('text-secondary');
        $('#opcionDenuncia').addClass('text-secondary');
        $('#opcionDenuncia').removeClass('text-white');
    });
    $('#nav-nuevaDenunciaForm-tab').on('shown.bs.tab', function (e) {
        document.getElementById("formFormatoPresentacionDenuncia").classList.remove("was-validated");
        if (tipoNuevaDenuncia != "editarInfo") {
            $('#nav-denuncias-tab').addClass('text-secondary');
            $('#nav-denuncias-tab').removeClass('text-white');
            $('#nav-adminuser-tab').addClass('text-secondary');
            $('#nav-adminuser-tab').removeClass('text-white');
            $('#opcionDenuncia').addClass('text-white');
            $('#opcionDenuncia').removeClass('text-secondary');
        } else {
            $('#nav-denuncias-tab').addClass('text-secondary');
            $('#nav-denuncias-tab').removeClass('text-white');
            $('#nav-adminuser-tab').addClass('text-secondary');
            $('#nav-adminuser-tab').removeClass('text-white');
            $('#opcionDenuncia').addClass('text-secondary');
            $('#opcionDenuncia').removeClass('text-white');
        }
    });
    $('#nav-nuevaDenunciaImg-tab').on('shown.bs.tab', function (e) {
        if (tipoNuevaDenuncia != "editarImg") {
            $('#nav-denuncias-tab').addClass('text-secondary');
            $('#nav-denuncias-tab').removeClass('text-white');
            $('#nav-adminuser-tab').addClass('text-secondary');
            $('#nav-adminuser-tab').removeClass('text-white');
            $('#opcionDenuncia').addClass('text-white');
            $('#opcionDenuncia').removeClass('text-secondary');
        } else {
            $('#nav-denuncias-tab').addClass('text-secondary');
            $('#nav-denuncias-tab').removeClass('text-white');
            $('#nav-adminuser-tab').addClass('text-secondary');
            $('#nav-adminuser-tab').removeClass('text-white');
            $('#opcionDenuncia').addClass('text-secondary');
            $('#opcionDenuncia').removeClass('text-white');
        }
    });
    $('#nav-nuevaDenunciaPDF-tab').on('shown.bs.tab', function (e) {
        if (tipoNuevaDenuncia != "editarPDF") {
            $('#nav-denuncias-tab').addClass('text-secondary');
            $('#nav-denuncias-tab').removeClass('text-white');
            $('#nav-adminuser-tab').addClass('text-secondary');
            $('#nav-adminuser-tab').removeClass('text-white');
            $('#opcionDenuncia').addClass('text-white');
            $('#opcionDenuncia').removeClass('text-secondary');
        } else {
            $('#nav-denuncias-tab').addClass('text-secondary');
            $('#nav-denuncias-tab').removeClass('text-white');
            $('#nav-adminuser-tab').addClass('text-secondary');
            $('#nav-adminuser-tab').removeClass('text-white');
            $('#opcionDenuncia').addClass('text-secondary');
            $('#opcionDenuncia').removeClass('text-white');
        }
    });
    $('#nav-vizualizador-tab').on('shown.bs.tab', function (e) {
        $('#nav-denuncias-tab').addClass('text-secondary');
        $('#nav-denuncias-tab').removeClass('text-white');
        $('#nav-adminuser-tab').addClass('text-secondary');
        $('#nav-adminuser-tab').removeClass('text-white');
        $('#opcionDenuncia').addClass('text-secondary');
        $('#opcionDenuncia').removeClass('text-white');
    });
    $('#nav-acuse-tab').on('shown.bs.tab', function (e) {
        $('#nav-denuncias-tab').addClass('text-secondary');
        $('#nav-denuncias-tab').removeClass('text-white');
        $('#nav-adminuser-tab').addClass('text-secondary');
        $('#nav-adminuser-tab').removeClass('text-white');
        $('#opcionDenuncia').addClass('text-secondary');
        $('#opcionDenuncia').removeClass('text-white');
    });
});

validarAccesos = (idUsuario) => {
    $.ajax({
        type: "POST",
        url: "ajax/ajaxLogin.php",
        data: {
            tipoPeticion: "validarAccesos",
            idUsuario
        },
        error: function (data) {
            console.error(data);
        },
        success: function (data) {
            let mensaje = data.split("|");
            if (mensaje[0] == "success") {
                // alertify.success(mensaje[1]);
            } else if (mensaje[0] == "warning") {
                alertify.error(mensaje[1]);
                salir();
            } else if (mensaje[0] == "error") {
                alertify.error(mensaje[1]);
            } else {
                console.log("Tipo de respuesta no definido. " + data);
            }
        }
    });
}

validarPermisos = (idUsuario) => {
    $.ajax({
        type: "POST",
        url: "ajax/ajaxLogin.php",
        data: {
            tipoPeticion: "validarPermisos",
            idUsuario
        },
        error: function (data) {
            console.error(data);
        },
        success: function (data) {
            let mensaje = data.split("|");
            if (mensaje[0] == "success") {
                let usuario = JSON.parse(mensaje[1])[0];
                let admin = false;
                usuario['tipoUsuario'] == 'Administrador' ? admin = true : admin = false;
                let adminElements = document.getElementsByClassName('adminElement');
                if (!admin) {
                    for (let i = 0; i < adminElements.length; i++) {
                        adminElements[i].classList.add('d-none');
                    }
                } else {
                    for (let i = 0; i < adminElements.length; i++) {
                        adminElements[i].classList.remove('d-none');
                    }
                }
            } else if (mensaje[0] == "error") {
                alertify.error(mensaje[1]);
            } else {
                console.log("Tipo de respuesta no definido. " + data);
            }
        }
    });
}

function obtenerFechas() {
    // FECHA ACTUAL Y -3 DIAS HABILES
    let f = new Date();
    let anio = f.getFullYear();
    let mes = f.getMonth() + 1;
    let dia = f.getDate();
    mes < 10 ? mes = '0' + mes : mes = mes;
    dia < 10 ? dia = '0' + dia : dia = dia;
    let fechaActual = anio + '-' + mes + '-' + dia;
    let i = 0;
    while (i < 8) {
        f.setTime(f.getTime() - 24 * 60 * 60 * 1000); // + 1 día
        if (f.getDay() != 6 && f.getDay() != 0) {
            i++;
        }
    }
    let fechaVerificar = f.getFullYear() + '-' + (f.getMonth() + 1) + '-' + f.getDate();
    return [fechaActual, fechaVerificar]
}

function verificarDenuncias() {
    let fechas = obtenerFechas();
    let fechaActual = fechas[0];
    let fechaVerificar = fechas[1];
    $.ajax({
        type: "POST",
        url: "ajax/ajaxCrudDenuncias.php?accion=verificarInconclusas",
        data: {
            fechaActual,
            fechaVerificar
        },
        error: function (data) {
            console.error("Error peticion ajax para enviar información de denuncia, DETALLES: " + data);
        },
        success: function (data) {
            let mensaje = data.split('|');
            if (mensaje[0] == "success") {
                alertify.success(mensaje[1]).delay(10);
            } else if (mensaje[0] == "warning") {
                alertify.warning(mensaje[1]).delay(10);
            } else if (mensaje[0] == "error") {
                alertify.error(mensaje[1]);
            } else {
                console.log("Tipo de respuesta no definido. " + data);
            }
        }
    });
}

function concluirDenunciasSinSeguimiento() {
    let fechaVerificar = obtenerFechas()[1];
    $.ajax({
        type: "POST",
        url: "ajax/ajaxCrudDenuncias.php?accion=concluirSinSeguimiento",
        data: {
            fechaVerificar
        },
        error: function (data) {
            console.error("Error peticion ajax para enviar información de denuncia, DETALLES: " + data);
        },
        success: function (data) {
            let mensaje = data.split('|');
            if (mensaje[0] == "success") {
                // alertify.success(mensaje[1]).delay(10);
            } else if (mensaje[0] == "warning") {
                alertify.warning(mensaje[1]).delay(10);
            } else if (mensaje[0] == "error") {
                alertify.error(mensaje[1]).delay(10);
            } else {
                console.log("Tipo de respuesta no definido. " + data);
            }
            enviarDenuncia(recolectarDatosDenuncia(), "leer");
        }
    });
}

function prepararValidacionDeFormularios() {
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
                if (form.id == "formFormatoPresentacionDenuncia") {
                    // if (document.getElementById("mostrarInfoDenunciante").checked == true && validarCamposDenunciante()) {
                    if ($("#txtIdDenuncia").val() == "") {
                        alertify.confirm('GUARDANDO DENUNCIA...', 'La información está incompleta, si prosigue se guardará como denuncia inconclusa.<br><br>Tendrá 3 dias para solicitar al denunciante subsane su información y 5 días para completarla. <ins>¡De lo contrario se archivará como concluida 8 días hábiles a partir de hoy!</ins>',
                            function () {
                                $("#txtStatusFormulario").val("inconclusa");
                                enviarDenuncia(recolectarDatosDenuncia(), "guardarInfo");
                            },
                            function () {
                                alertify.error('Cancelado')
                            }
                        ).set('labels', { cancel: 'Cancelar' });
                    } else {
                        if (!document.getElementById("contenedorInformacionDenunciante").classList.contains("d-none")) {
                            alertify.confirm('EDITANDO DENUNCIA...', 'La información está incompleta, si prosigue se guardará como denuncia inconclusa.<br><br>Tendrá 3 dias para solicitar al denunciante subsane su información y 5 días para completarla. <ins>¡De lo contrario se archivará como concluida 8 días hábiles a partir de su fecha de presentación!</ins>',
                                function () {
                                    $("#txtStatusFormulario").val("inconclusa");
                                    enviarDenuncia(recolectarDatosDenuncia(), "editarInfo");
                                },
                                function () {
                                    alertify.error('Cancelado')
                                }
                            ).set('labels', { cancel: 'Cancelar' });
                        }
                    }
                    // } else {
                    //     alertify.error("Verifique almenos la información del denunciante");
                    // }
                }
            } else {
                event.preventDefault();
                if (form.id == "formFormatoPresentacionDenuncia") {
                    if (!document.getElementById("mostrarInfoDenunciante").checked) {
                        vaciarCamposDenunciante();
                    }
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
                } else if (form.id == "formPdfFormatoPresentacionDenuncia") {
                    if ($("#txtIdDenunciaPDF").val() == "") {
                        enviarPdfDenuncia(form.id, "guardarPDF");
                    } else {
                        enviarPdfDenuncia(form.id, "editarPDF");
                    }
                } else if (form.id == "formActaDenuncia") {
                    concluirDenuncia(form.id);
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
        document.getElementById("txtFechaPresentacion").removeAttribute("disabled");
        document.getElementById("contenedorSwitchCamposDenunciante").classList.remove("d-none");
        document.getElementById("contenedorInformacionDenunciante").classList.remove("d-none");
        requerirCamposDenunciante();
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
        document.getElementById("txtImagenFechaPresentacionV").removeAttribute("disabled");
        $("#labelImgDenuncia").html("Elegir imagen...");
        $("#contenedorImagen").empty();
        $("#modalPresuntoDenuncia").modal("hide");
        $('#nav-nuevaDenunciaImg-tab').tab('show');
    } else if (tipoNuevaDenuncia == "subirPDF") {
        document.getElementById("formPdfFormatoPresentacionDenuncia").reset();
        $("#txtIdDenunciaPDF").val("");
        $("#contenedorNumExpedientePDF").addClass("d-none");
        $("#txtDenunciaPDF").prop("required", true);
        cadPresuntoDenuncia = "Denuncia por " + presuntoDenuncia[presunto];
        $("#txtPresuntoDenunciaPDF").html(cadPresuntoDenuncia);
        $("#txtFechaPresentacionPDF").val(cadFechaActual);
        $("#txtFechaPresentacionPDFV").val(cadFechaActual);
        document.getElementById("txtFechaPresentacionPDFV").removeAttribute("disabled");
        $("#labelDenunciaPDF").html("Elegir documento...");
        $("#contenedorPDF").empty();
        $("#modalPresuntoDenuncia").modal("hide");
        $('#nav-nuevaDenunciaPDF-tab').tab('show');
    } else if (tipoNuevaDenuncia == "editarInfo") {
        cadPresuntoDenuncia = "Denuncia por " + presuntoDenuncia[presunto];
        $("#txtPresuntoDenuncia").html(cadPresuntoDenuncia);
        $("#modalPresuntoDenuncia").modal("hide");
    } else if (tipoNuevaDenuncia == "editarImg") {
        cadPresuntoDenuncia = "Denuncia por " + presuntoDenuncia[presunto];
        $("#txtImagenPresuntoDenuncia").html(cadPresuntoDenuncia);
        $("#modalPresuntoDenuncia").modal("hide");
    } else if (tipoNuevaDenuncia == "editarPDF") {
        cadPresuntoDenuncia = "Denuncia por " + presuntoDenuncia[presunto];
        $("#txtPresuntoDenunciaPDF").html(cadPresuntoDenuncia);
        $("#modalPresuntoDenuncia").modal("hide");
    }
}

function vaciarCamposDenunciante() {
    document.getElementById("txtAnonimatoDenunciante").value = "";
    document.getElementById("txtNombreDenunciante").value = "";
    document.getElementById("txtDomicilioDenunciante").value = "";
    document.getElementById("txtTelefonoDenunciante").value = "";
    document.getElementById("txtCorreoDenunciante").value = "";
    document.getElementById("txtSexoDenunciante").value = "";
    document.getElementById("txtEdadDenunciante").value = "";
    document.getElementById("txtSPDenunciante").value = "";
    document.getElementById("txtPuestoDenunciante").value = "";
    document.getElementById("txtEspecificarDenunciante").value = "";
    document.getElementById("txtGradoEstudiosDenunciante").value = "";
    document.getElementById("txtDiscapacidadDenunciante").value = "";
}

function noRequerirCamposDenunciante() {
    document.getElementById("txtAnonimatoDenunciante").removeAttribute("required");
    document.getElementById("txtNombreDenunciante").removeAttribute("required");
    document.getElementById("txtDomicilioDenunciante").removeAttribute("required");
    document.getElementById("txtTelefonoDenunciante").removeAttribute("required");
    document.getElementById("txtCorreoDenunciante").removeAttribute("required");
    document.getElementById("txtSexoDenunciante").removeAttribute("required");
    document.getElementById("txtEdadDenunciante").removeAttribute("required");
    document.getElementById("txtSPDenunciante").removeAttribute("required");
    document.getElementById("txtPuestoDenunciante").removeAttribute("required");
    document.getElementById("txtEspecificarDenunciante").removeAttribute("required");
    document.getElementById("txtGradoEstudiosDenunciante").removeAttribute("required");
    document.getElementById("txtDiscapacidadDenunciante").removeAttribute("required");
}

function requerirCamposDenunciante() {
    document.getElementById("txtAnonimatoDenunciante").setAttribute("required", "");
    document.getElementById("txtNombreDenunciante").setAttribute("required", "");
    document.getElementById("txtDomicilioDenunciante").setAttribute("required", "");
    document.getElementById("txtTelefonoDenunciante").setAttribute("required", "");
    document.getElementById("txtCorreoDenunciante").setAttribute("required", "");
    document.getElementById("txtSexoDenunciante").setAttribute("required", "");
    document.getElementById("txtEdadDenunciante").setAttribute("required", "");
    document.getElementById("txtSPDenunciante").setAttribute("required", "");
    document.getElementById("txtPuestoDenunciante").setAttribute("required", "");
    document.getElementById("txtEspecificarDenunciante").setAttribute("required", "");
    document.getElementById("txtGradoEstudiosDenunciante").setAttribute("required", "");
    document.getElementById("txtDiscapacidadDenunciante").setAttribute("required", "");
}

function validarCamposDenunciante() {
    if (
        document.getElementById("txtAnonimatoDenunciante").checkValidity() === true &&
        document.getElementById("txtNombreDenunciante").checkValidity() === true &&
        document.getElementById("txtDomicilioDenunciante").checkValidity() === true &&
        document.getElementById("txtTelefonoDenunciante").checkValidity() === true &&
        document.getElementById("txtCorreoDenunciante").checkValidity() === true &&
        document.getElementById("txtSexoDenunciante").checkValidity() === true &&
        document.getElementById("txtEdadDenunciante").checkValidity() === true &&
        document.getElementById("txtSPDenunciante").checkValidity() === true &&
        document.getElementById("txtPuestoDenunciante").checkValidity() === true &&
        document.getElementById("txtEspecificarDenunciante").checkValidity() === true &&
        document.getElementById("txtGradoEstudiosDenunciante").checkValidity() === true &&
        document.getElementById("txtDiscapacidadDenunciante").checkValidity() === true
    ) {
        return true;
    } else {
        return false;
    }
}

function recolectarDatosDenuncia() {
    if ($("#txtFechaDenuncia").val() == "") {
        $("#txtFechaDenuncia").val($("#txtFechaPresentacion").val());
    }
    if ($("#txtHoraDenuncia").val() == "") {
        $("#txtHoraDenuncia").val("00:00");
    }
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
                validarPermisos(sesion); // VALIDAR PERMISOS !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
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

function enviarPdfDenuncia(form, accion) {
    if (accion == "guardarPDF") {
        $("#txtPresuntoPDF").val(cadPresuntoDenuncia);
    } else {
        $("#txtPresuntoPDF").val($("#txtPresuntoDenunciaPDF").html());
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
            document.getElementById(form).reset();
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

function concluirDenuncia(form) {
    var formData = new FormData(document.getElementById(form));
    $.ajax({
        type: "POST",
        url: "ajax/ajaxCrudDenuncias.php?accion=guardarActa",
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    }).done(function (data) {
        let mensaje = data.split('|');
        if (mensaje[0] == 'success') {
            $('#modalConcluirDenuncia').modal('hide');
            enviarDenuncia(recolectarDatosDenuncia(), "leer");
            document.getElementById(form).reset();
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
        "lengthMenu": [[5, 20, 50, -1], [5, 20, 50, "Todos"]],
        "order": [[2, "asc"]],
        responsive: "true",
        "sDom": "<'row'<'col-lg-3 col-md-4 col-9'l><'col-lg-5 col-md-3 col-3'B><'col-lg-4 col-md-5 col-12'f>r>t<'row'<'col-md-7 col-12'i><'col-md-5 col-12'p>>",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i>',
                titleAttr: 'Exportar a excel',
                className: 'btn btn-sm btn-success bg-primary text-white'
            }
        ],
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
        "lengthMenu": [[5, 20, 50, -1], [5, 20, 50, "Todos"]],
        "order": [[2, "asc"]],
        responsive: "true",
        "sDom": "<'row'<'col-lg-3 col-md-4 col-9'l><'col-lg-5 col-md-3 col-3'B><'col-lg-4 col-md-5 col-12'f>r>t<'row'<'col-md-7 col-12'i><'col-md-5 col-12'p>>",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i>',
                titleAttr: 'Exportar a excel',
                className: 'btn btn-sm btn-success bg-primary text-white'
            }
        ],
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
        "lengthMenu": [[5, 20, 50, -1], [5, 20, 50, "Todos"]],
        "order": [[2, "asc"]],
        responsive: "true",
        "sDom": "<'row'<'col-lg-3 col-md-4 col-9'l><'col-lg-5 col-md-3 col-3'B><'col-lg-4 col-md-5 col-12'f>r>t<'row'<'col-md-7 col-12'i><'col-md-5 col-12'p>>",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i>',
                titleAttr: 'Exportar a excel',
                className: 'btn btn-sm btn-success bg-primary text-white'
            }
        ],
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
}

function prepararParaEditar(idDenuncia, tipoDenuncia, numExpediente, fechaPresentacion, imagenDenuncia, pdfDenuncia, anonimatoDenunciante, nombreDenunciante, domicilioDenunciante, telefonoDenunciante, correoDenunciante, sexoDenunciante, edadDenunciante, servidorPublicoDenunciante, puestoDenunciante, especificarDenunciante, gradoEstudiosDenunciante, discapacidadDenunciante, nombreDenunciado, entidadDenunciado, telefonoDenunciado, correoDenunciado, sexoDenunciado, edadDenunciado, servidorPublicoDenunciado, especificarDenunciado, relacionDenunciado, lugarDenuncia, fechaDenuncia, horaDenuncia, narracionDenuncia, nombreTestigo, domicilioTestigo, telefonoTestigo, correoTestigo, relacionTestigo, trabajaTestigo, entidadTestigo, cargoTestigo, statusDenuncia) {
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
        document.getElementById("txtImagenFechaPresentacionV").setAttribute("disabled", "");
        $("#labelImgDenuncia").html("Elegir imagen...");
        let contenedorImagen = document.getElementById('contenedorImagen');
        let image = document.createElement('img');
        image.src = "data:image/jpeg;base64," + imagenDenuncia;
        image.style = "height: 30vh; max-width: 27rem;";
        contenedorImagen.innerHTML = '';
        contenedorImagen.append(image);
        $('#nav-nuevaDenunciaImg-tab').tab('show');
    } else if (pdfDenuncia != "") {
        tipoNuevaDenuncia = "editarPDF";
        $("#txtDenunciaPDF").prop("required", false);
        $("#contenedorNumExpedientePDF").removeClass("d-none");
        $("#txtIdDenunciaPDF").val(idDenuncia);
        $("#txtPresuntoPDF").val(tipoDenuncia);
        $("#txtPresuntoDenunciaPDF").html(tipoDenuncia);
        $("#txtNumExpedientePDF").val(numExpediente);
        $("#txtNumExpedientePDFV").val(numExpediente);
        $("#txtFechaPresentacionPDF").val(fechaPresentacion);
        $("#txtFechaPresentacionPDFV").val(fechaPresentacion);
        document.getElementById("txtFechaPresentacionPDFV").setAttribute("disabled", "");
        $("#labelDenunciaPDF").html("Elegir documento...");
        let contenedorPDF = document.getElementById('contenedorPDF');
        let pdf = document.createElement('object');
        pdf.data = "data:application/pdf;base64," + pdfDenuncia;
        pdf.style = "height: 40vh; width: 80vh;";
        contenedorPDF.innerHTML = '';
        contenedorPDF.append(pdf);
        $('#nav-nuevaDenunciaPDF-tab').tab('show');
    } else {
        document.getElementById("contenedorSwitchCamposDenunciante").classList.add("d-none");
        if (nombreDenunciante == "") {
            document.getElementById("contenedorInformacionDenunciante").classList.add("d-none");
            noRequerirCamposDenunciante();
        } else {
            document.getElementById("contenedorInformacionDenunciante").classList.remove("d-none");
            requerirCamposDenunciante();
        }
        tipoNuevaDenuncia = "editarInfo";
        $("#txtNumExpediente").val(numExpediente);
        $("#contenedorNumExpediente").removeClass("d-none");
        $("#txtTareaFormulario").val("editarInfo");
        $("#txtStatusFormulario").val(statusDenuncia);
        $("#txtIdDenuncia").val(idDenuncia);
        $("#txtPresuntoDenuncia").html(tipoDenuncia);
        $("#txtFechaPresentacion").val(fechaPresentacion);
        document.getElementById("txtFechaPresentacion").setAttribute("disabled", "");
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

function prepararParaVizualizar(tipoDenuncia, numExpediente, fechaPresentacion, imagenDenuncia, pdfDenuncia, anonimatoDenunciante, nombreDenunciante, domicilioDenunciante, telefonoDenunciante, correoDenunciante, sexoDenunciante, edadDenunciante, servidorPublicoDenunciante, puestoDenunciante, especificarDenunciante, gradoEstudiosDenunciante, discapacidadDenunciante, nombreDenunciado, entidadDenunciado, telefonoDenunciado, correoDenunciado, sexoDenunciado, edadDenunciado, servidorPublicoDenunciado, especificarDenunciado, relacionDenunciado, lugarDenuncia, fechaDenuncia, horaDenuncia, narracionDenuncia, nombreTestigo, domicilioTestigo, telefonoTestigo, correoTestigo, relacionTestigo, trabajaTestigo, entidadTestigo, cargoTestigo, statusDenuncia) {
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
    } else if (pdfDenuncia != "") {
        $("#contenedorImagenGeneral").removeClass("d-none");
        $("#contenedorDatosGenerales").addClass("d-none");
        let contenedorImagenFormato = document.getElementById('contenedorImagenFormato');
        let pdf = document.createElement('object');
        pdf.data = "data:application/pdf;base64," + pdfDenuncia;
        pdf.style = "height: 150vh; width: 150vh;";
        contenedorImagenFormato.innerHTML = '';
        contenedorImagenFormato.append(pdf);
    } else {
        $("#contenedorDatosGenerales").removeClass("d-none");
        $("#contenedorImagenGeneral").addClass("d-none");
    }
    let presuntoDenuncia = tipoDenuncia.split("-");
    $("#txtPresuntoDenunciaV").html(presuntoDenuncia[0]);
    if (presuntoDenuncia[1]) {
        $("#txtPresuntoDenunciaV2").html(presuntoDenuncia[1]);
    } else {
        $("#txtPresuntoDenunciaV2").html("");
    }
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

function prepararParaGenerarAcuse(tipoDenuncia, numExpediente, fechaPresentacion, horaPresentacion, imagenDenuncia, pdfDenuncia, anonimatoDenunciante, nombreDenunciante, domicilioDenunciante, telefonoDenunciante, correoDenunciante, sexoDenunciante, edadDenunciante, servidorPublicoDenunciante, puestoDenunciante, especificarDenunciante, gradoEstudiosDenunciante, discapacidadDenunciante, nombreDenunciado, entidadDenunciado, telefonoDenunciado, correoDenunciado, sexoDenunciado, edadDenunciado, servidorPublicoDenunciado, especificarDenunciado, relacionDenunciado, lugarDenuncia, fechaDenuncia, horaDenuncia, narracionDenuncia, nombreTestigo, domicilioTestigo, telefonoTestigo, correoTestigo, relacionTestigo, trabajaTestigo, entidadTestigo, cargoTestigo) {
    if (imagenDenuncia != "") {
        $("#contenedorImagenGeneralAcuse").removeClass("d-none");
        $("#contenedorDatosGeneralesAcuse").addClass("d-none");
        let contenedorImagenFormatoAcuse = document.getElementById('contenedorImagenFormatoAcuse');
        let image = document.createElement('img');
        image.src = "data:image/jpeg;base64," + imagenDenuncia;
        image.style = "width: 100vh";
        image.class = "border";
        contenedorImagenFormatoAcuse.innerHTML = '';
        contenedorImagenFormatoAcuse.append(image);
    } else if (pdfDenuncia != "") {
        $("#contenedorImagenGeneralAcuse").removeClass("d-none");
        $("#contenedorDatosGeneralesAcuse").addClass("d-none");
        let contenedorImagenFormatoAcuse = document.getElementById('contenedorImagenFormatoAcuse');
        let pdf = document.createElement('object');
        pdf.data = "data:application/pdf;base64," + pdfDenuncia;
        pdf.style = "height: 150vh; width: 150vh;";
        contenedorImagenFormatoAcuse.innerHTML = '';
        contenedorImagenFormatoAcuse.append(pdf);
    } else {
        $("#contenedorDatosGeneralesAcuse").removeClass("d-none");
        $("#contenedorImagenGeneralAcuse").addClass("d-none");
    }
    let presuntoDenuncia = tipoDenuncia.split("-");
    $("#txtPresuntoDenunciaV").html(presuntoDenuncia[0]);
    if (presuntoDenuncia[1]) {
        $("#txtPresuntoDenunciaV2").html(presuntoDenuncia[1]);
    } else {
        $("#txtPresuntoDenunciaV2").html("");
    }
    $("#txtNumExpedienteAcuse").val(numExpediente);
    $("#txtFechaRecepcionAcuse").val(fechaPresentacion);
    $("#txtHoraRecepcionAcuse").val(horaPresentacion);
    $("#txtAnonimatoDenuncianteA").val(anonimatoDenunciante);
    $("#txtNombreDenuncianteA").val(nombreDenunciante);
    $("#txtDomicilioDenuncianteA").val(domicilioDenunciante);
    $("#txtTelefonoDenuncianteA").val(telefonoDenunciante);
    $("#txtCorreoDenuncianteA").val(correoDenunciante);
    $("#txtSexoDenuncianteA").val(sexoDenunciante);
    $("#txtEdadDenuncianteA").val(edadDenunciante);
    $("#txtSPDenuncianteA").val(servidorPublicoDenunciante);
    if (servidorPublicoDenunciante == "si") {
        $("#inputPuestoA").removeClass("d-none");
        $("#inputEspecificarA").addClass("d-none");
    } else if (servidorPublicoDenunciante == "no") {
        $("#inputPuestoA").addClass("d-none");
        $("#inputEspecificarA").removeClass("d-none");
    } else {
        $("#inputPuestoA").addClass("d-none");
        $("#inputEspecificarA").addClass("d-none");
    }
    $("#txtPuestoDenuncianteA").val(puestoDenunciante);
    $("#txtEspecificarDenuncianteA").val(especificarDenunciante);
    $("#txtGradoEstudiosDenuncianteA").val(gradoEstudiosDenunciante);
    $("#txtDiscapacidadDenuncianteA").val(discapacidadDenunciante);
    $("#txtNombreDenunciadoA").val(nombreDenunciado);
    $("#txtEntidadDenunciadoA").val(entidadDenunciado);
    $("#txtTelefonoDenunciadoA").val(telefonoDenunciado);
    $("#txtCorreoDenunciadoA").val(correoDenunciado);
    $("#txtSexoDenunciadoA").val(sexoDenunciado);
    $("#txtEdadDenunciadoA").val(edadDenunciado);
    $("#txtSPDenunciadoA").val(servidorPublicoDenunciado);
    $("#txtEspecificarDenunciadoA").val(especificarDenunciado);
    $("#txtRelacionDenunciadoA").val(relacionDenunciado);
    $("#txtLugarDenunciaA").val(lugarDenuncia);
    $("#txtFechaDenunciaA").val(fechaDenuncia);
    $("#txtHoraDenunciaA").val(horaDenuncia);
    $("#txtNarracionDenunciaA").val(narracionDenuncia);
    $("#txtNombreTestigoA").val(nombreTestigo);
    $("#txtDomicilioTestigoA").val(domicilioTestigo);
    $("#txtTelefonoTestigoA").val(telefonoTestigo);
    $("#txtCorreoTestigoA").val(correoTestigo);
    $("#txtRelacionTestigoA").val(relacionTestigo);
    $("#txtTrabajaTestigoA").val(trabajaTestigo);
    if (trabajaTestigo == "si") {
        $("#inputEDA").removeClass("d-none");
        $("#inputCargoA").removeClass("d-none");
    } else if (trabajaTestigo == "no") {
        $("#inputEDA").addClass("d-none");
        $("#inputCargoA").addClass("d-none");
    } else {
        $("#inputEDA").addClass("d-none");
        $("#inputCargoA").addClass("d-none");
    }
    $("#txtEntidadTestigoA").val(entidadTestigo);
    $("#txtCargoTestigoA").val(cargoTestigo);
    $('#nav-acuse-tab').tab('show');
}

function prepararParaConcluir(idDenuncia, tipoDenuncia, numExpediente, fechaPresentacion) {
    document.getElementById('formActaDenuncia').reset();
    document.getElementById('txtIdDenunciaActa').value = idDenuncia;
    document.getElementById('txtPresuntoDenunciaActa').innerHTML = tipoDenuncia;
    document.getElementById('txtNumExpedienteActa').value = numExpediente;
    document.getElementById('txtFechaPresentacionActa').value = fechaPresentacion;
    document.getElementById('labelActaDenunciaPDF').innerHTML = 'Elegir documento...';
    $('#contenedorActaPDF').empty();
    $('#modalConcluirDenuncia').modal('show');
}

function prepararParaMostrarActa(pdfActaDenuncia) {
    let contenedorVizualizarActaPDF = document.getElementById('contenedorVizualizarActaPDF');
    let pdf = document.createElement('object');
    pdf.data = "data:application/pdf;base64," + pdfActaDenuncia;
    pdf.style = "height: 70vh; width: 70vh;";
    contenedorVizualizarActaPDF.innerHTML = '';
    contenedorVizualizarActaPDF.append(pdf);
    $('#modalActaDenuncia').modal('show');
}

salir = () => {
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
}