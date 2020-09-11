let tipoNuevaDenuncia = "";
let presuntoDenuncia = ["presunto incumplimiento al código de ética.", "presunto incumplimiento a las reglas de integridad.", "presunto incumplimiento al código de conducta.", "presunta agresión.", "presunto amedrentamiento.", "presunta intimidación.", "presuntas amenazas."];

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
        } else if (sp == "no") {
            $("#inputPuesto").addClass("d-none");
            $("#inputEspecificar").removeClass("d-none");
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
        } else if (ta == "no") {
            $("#inputED").addClass("d-none");
            $("#inputCargo").addClass("d-none");
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
        $("#txtPresuntoDenuncia").html("Denuncia por " + presuntoDenuncia[presunto]);
        $("#txtFechaPresentacion").val(cadFechaActual);
        $("#inputPuesto").addClass("d-none");
        $("#inputEspecificar").addClass("d-none");
        $("#modalPresuntoDenuncia").modal("hide");
        $('#nav-nuevaDenunciaForm-tab').tab('show');
    } else if (tipoNuevaDenuncia == "subirImagen") {
        $("#modalPresuntoDenuncia").modal("hide");
        $('#nav-nuevaDenunciaImg-tab').tab('show');
    }
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