<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: /AtencionADenuncias/home");
} else {
?>
    <div id="particles-js"></div>
    <div class="container contenedor" style="overflow-y: hidden;">
        <div class="row align-items-center justify-content-center" style="height: 100vh;">
            <div class="col-lg-7 col-sm-6 col-12">
                <div class="row align-items-center justify-content-start">
                    <div class="card border border-0 bg-transparent">
                        <div class="card-body">
                            <h3 class="card-text text-justify text-white">ATENCIÓN A DENUNCIAS POR LOS INCUMPLIMIENTOS DEL CÓDIGO DE ÉTICA DE LA ADMINISTRACIÓN PÚBLICA DEL ESTADO DE HIDALGO Y CÓDIGO DE CONDUCTA DE OFICIALÍA MAYOR.</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-sm-6 col-12">
                <div class="row align-items-center justify-content-end">
                    <div class="card" style="max-width: 20rem;">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Identifícate</h5>
                            <div class="dropdown-divider"></div>
                            <form id="formIdentificarUsuario" class="needs-validation" novalidate>
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="txtUsuario">Usuario</label>
                                        <input type="text" class="form-control" id="txtUsuario" required>
                                        <div class="valid-feedback">
                                            Correcto!
                                        </div>
                                        <div class="invalid-feedback">
                                            Verifica tu usuario
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="txtPassword">Contraseña</label>
                                        <input type="password" class="form-control" id="txtPassword" required>
                                        <div class="valid-feedback">
                                            Correcto!
                                        </div>
                                        <div class="invalid-feedback">
                                            Verifica tu contraseña
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row d-flex justify-content-end">
                                    <button class="btn btn-outline-primary" type="submit">
                                        Ingresar
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </button>
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
        background-color: #092432;
    }

    .contenedor {
        position: relative;
        height: 85vh;
        z-index: 1;
    }
</style>