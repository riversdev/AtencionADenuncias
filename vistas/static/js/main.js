let presuntoDenuncia = "";

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
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
        $('#nav-nuevaDenunciaForm-tab').tab('show');
        $("#modalPresuntoDenuncia").modal("show");
    });
    $('#subirImagen').on('click', function () {
        $('#nav-nuevaDenunciaImg-tab').tab('show');
        $("#modalPresuntoDenuncia").modal("show");
    });
    $('#presunto1').on('click', function () {
        presuntoDenuncia = "1";
        $("#modalPresuntoDenuncia").modal("hide");
    });
    $('#presunto2').on('click', function () {
        presuntoDenuncia = "2";
        $("#modalPresuntoDenuncia").modal("hide");
    });
    $('#presunto3').on('click', function () {
        presuntoDenuncia = "3";
        $("#modalPresuntoDenuncia").modal("hide");
    });
    $('#presunto4').on('click', function () {
        presuntoDenuncia = "4";
        $("#modalPresuntoDenuncia").modal("hide");
    });
    $('#presunto5').on('click', function () {
        presuntoDenuncia = "5";
        $("#modalPresuntoDenuncia").modal("hide");
    });
    $('#presunto6').on('click', function () {
        presuntoDenuncia = "6";
        $("#modalPresuntoDenuncia").modal("hide");
    });
    $('#presunto7').on('click', function () {
        presuntoDenuncia = "7";
        $("#modalPresuntoDenuncia").modal("hide");
    });

    // DENUNCIAS
    //obtenerDenuncias("inconclusas");
    //obtenerDenuncias("pendientes");
    //obtenerDenuncias("concluidas");
});

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