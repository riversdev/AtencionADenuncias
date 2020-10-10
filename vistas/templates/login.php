<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: /AtencionADenuncias/home");
} else {
?>

    <div id="particles-js"></div>
    <div class="container contenedor" style="overflow-y: hidden;">
        <div class="row align-items-center justify-content-center" style="height: 100vh;">
            <div class="contact100-more flex-col-c-m col-lg-6 col-md-6 col-sm-12" style="color:white; max-width: 50%;max-height: 100%">
                <div class="flex-w size1 p-b-47">
                    <img src="vistas/static/img/logo_ofi.png" style="height: 14vh; padding-right: 150px">
                    <img src="vistas/static/img/Escudo_de_Armas_Oficial_del_Estado_de_Hidalgo.png" style="height: 14vh;">
                    <div class="card-text text-justify" style="padding-top: 30px; font-size: 20px; color:black"><span><strong> Atención a Denuncias por los Incumplimientos del Código de Ética de la Administración Pública del Estado de Hidalgo y Código de Conducta de Oficialía Mayor</strong></span></div>
                </div>
            </div>
            <div class="col-lg-5 col-sm-6 col-12">
                <div class="row align-items-center justify-content-end">
                    <div class="card" style="max-width: 20rem; box-shadow: 5px 5px 10px gray; ">
                        <div class="card-body">
                            <h5 class="card-title text-dark text-center">Identifícate</h5>
                            <div class="dropdown-divider border border-bottom-0"></div>
                            <form id="formIdentificarUsuario" class="needs-validation" novalidate>
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="txtUsuario"><i class="fa fa-user-circle "></i> Usuario</label>
                                        <input type="text" class="form-control" id="txtUsuario" required>
                                        <div class="valid-feedback">
                                            Correcto!
                                        </div>
                                        <div class="invalid-feedback">
                                            Verifica tu usuario
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="txtPassword"><i class="fa fa-key"></i> Contraseña</label>
                                        <input type="password" class="form-control" id="txtPassword" required>
                                        <div class="valid-feedback">
                                            Correcto!
                                        </div>
                                        <div class="invalid-feedback">
                                            Verifica tu contraseña
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 d-flex justify-content-center">
                                        <button class="btn btn-outline-dark btn-block" type="submit">
                                            Ingresar
                                            <i class="fas fa-arrow-circle-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>

<!-- PARTICLES JS 2.0.0 -->
<script src="vistas\static\particles\particles.js-master\particles.js"></script>
<script src="vistas\static\particles\app.js"></script>

<script>
    // VALIDACION DE FORMULARIOS BIENVENIDA Y EVENTOS SUBMIT
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        event.preventDefault();
                        if (form.id == "formIdentificarUsuario") {
                            let txtUsuario = document.getElementById("txtUsuario").value;
                            let txtPassword = document.getElementById("txtPassword").value;
                            $.ajax({
                                type: "POST",
                                url: "ajax/ajaxLogin.php",
                                data: {
                                    tipoPeticion: "identificacion",
                                    txtUsuario,
                                    txtPassword
                                },
                                error: function(data) {
                                    console.error(data);
                                },
                                success: function(data) {
                                    let mensaje = data.split("|");
                                    if (mensaje[0] == "success") {
                                        location.href = "home";
                                    } else if (mensaje[0] == "warning") {
                                        alertify.error(mensaje[1]);
                                    } else if (mensaje[0] == "error") {
                                        alertify.error(mensaje[1]);
                                    } else {
                                        console.log("Tipo de respuesta no definido. " + data);
                                    }
                                }
                            });
                        } else {
                            console.log("Formulario no encontrado");
                        }
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<style>
    #particles-js {
        height: 100vh;
        width: 100%;
        position: fixed;
        z-index: -1;
        background-color: gray;
    }

    .contenedor {
        position: relative;
        height: 85vh;
        z-index: 1;
    }
</style>