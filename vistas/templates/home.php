<?php
session_start();

if (isset($_SESSION['user_id'])) {
    require_once "modelos/modeloConexion.php";
    $idUsuario = $_SESSION['user_id'];
    $stmt = Conexion::conectar()->prepare("SELECT usuario,email FROM usuarios WHERE idUsuario='$idUsuario';");
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    $usuario = null;
    if (count($resultado) > 0) {
        $usuario = $resultado;
        $stmt = null;
    }
?>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="vistas\static\css\main.css">
    <!-- Custom JS -->
    <script src="vistas\static\js\main.js"></script>
    <!-- Main usuarios -->
    <script src="vistas/static/js/AdminUser.js"></script>

    <script>
        let sesion = "<?php echo $_SESSION['user_id']; ?>";

        // ACCESOS
        setInterval(function() {
            validarAccesos(sesion);
        }, 600000);

        // PERMISOS
        setInterval(function() {
            enviarDenuncia(recolectarDatosDenuncia(), "leer");
        }, 540000);

        // VERIFICACIONES
        concluirDenunciasSinSeguimiento();
        verificarDenuncias();
        alertify.success("Todo está listo !");

        setInterval(function() {
            verificarDenuncias();
        }, 3600000); // CADA HORA
    </script>

    <!-- Navegaciones -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <img src="vistas\static\img\Oficialiia.png" class="pr-3" style="height: 7vh;">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <div class="nav d-flex justify-content-center align-items-center" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-denuncias-tab" data-toggle="tab" href="#nav-denuncias" role="tab" aria-controls="nav-denuncias" aria-selected="true">
                        <i class="fa fa-gavel"></i> Denuncias
                    </a>
                    <a class="nav-item nav-link text-secondary adminElement" id="nav-adminuser-tab" data-toggle="tab" href="#nav-adminuser" role="tab" aria-controls="nav-adminuser" aria-selected="false">
                        <i class="fa fa-users"></i> Administrar Usuarios
                    </a>
                    <a class="nav-item nav-link d-none" id="nav-nuevaDenunciaForm-tab" data-toggle="tab" href="#nav-nuevaDenunciaForm" role="tab" aria-controls="nav-nuevaDenunciaForm" aria-selected="false">
                        Nueva denuncia - Llenar formulario - Invisible
                    </a>
                    <a class="nav-item nav-link d-none" id="nav-nuevaDenunciaImg-tab" data-toggle="tab" href="#nav-nuevaDenunciaImg" role="tab" aria-controls="nav-nuevaDenunciaImg" aria-selected="false">
                        Nueva denuncia - Subir imagen - Invisible
                    </a>
                    <a class="nav-item nav-link d-none" id="nav-nuevaDenunciaPDF-tab" data-toggle="tab" href="#nav-nuevaDenunciaPDF" role="tab" aria-controls="nav-nuevaDenunciaPDF" aria-selected="false">
                        Nueva denuncia - Subir PDF - Invisible
                    </a>
                    <a class="nav-item nav-link d-none" id="nav-vizualizador-tab" data-toggle="tab" href="#nav-vizualizador" role="tab" aria-controls="nav-vizualizador" aria-selected="false">
                        vizualizador - Invisible
                    </a>
                    <a class="nav-item nav-link d-none" id="nav-acuse-tab" data-toggle="tab" href="#nav-acuse" role="tab" aria-controls="nav-acuse" aria-selected="false">
                        Acuse - Invisible
                    </a>
                </div>
                <li class="nav-item dropdown adminElement">
                    <a class="nav-link dropdown-toggle text-secondary" id="opcionDenuncia" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-plus"></i> Nueva denuncia
                    </a>
                    <div class="dropdown-menu shadow" aria-labelledby="opcionDenuncia">
                        <a class="dropdown-item" id="llenarFormulario">Llenar formulario</a>
                        <a class="dropdown-item" id="subirImagen">Subir imagen</a>
                        <a class="dropdown-item" id="subirPDF">Subir PDF</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <button type="button" class="btn btn-outline-light d-none" id="btnAgregarUsuario" data-toggle="modal" data-target="#newAdmin">
                    <i class="fas fa-user-plus" data-toggle="tooltip" data-placement="bottom" title="Agregar usuario"></i>
                </button>
                <button type="button" class="btn btn-outline-light d-none" id="btnImprimir" data-toggle="tooltip" data-placement="bottom" title="Imprimir">
                    <i class="fas fa-print"></i>
                </button>
                <div class="btn-group pl-3">
                    <button type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="far fa-user"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow">
                        <div class="dropdown-item-text text-center">
                            <h4 class="text-dark"><?php echo $usuario['usuario']; ?></h4>
                            <label class="text-dark"><?php echo $usuario['email']; ?></label>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-item text-center bg-white">
                            <button id="salir" type="button" class="btn btn-sm btn-danger">Cerrar sesión</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </nav>
    <nav class="navbar navbar-light bg-white d-none" id="navTipoDenuncia">
        <form class="px-5 pt-2" style="width: 100%;">
            <div class="form-row">
                <div class="col-12" style="color: #537F33;">
                    <h6 class="text-justify text-center text-uppercase" id="txtPresuntoDenunciaV"></h6>
                    <h6 class="text-center text-danger" id="txtPresuntoDenunciaV2"></h6>
                </div>
            </div>
        </form>
    </nav>

    <!-- Contenido -->
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-denuncias" role="tabpanel" aria-labelledby="nav-denuncias-tab">
            <div id="contenedorTablasDenuncias"></div>
        </div>
        <div class="tab-pane fade" id="nav-nuevaDenunciaForm" role="tabpanel" aria-labelledby="nav-nuevaDenunciaForm-tab">
            <div class="card bg-white shadow mx-5 my-4" style="border: 0; border-left: 0; border-right: 0; border-bottom: 0;">
                <div class="card-body rounded" style="border-top: 5px solid #b91926;">
                    <form id="formFormatoPresentacionDenuncia" class="needs-validation" novalidate>
                        <input type="hidden" id="txtTareaFormulario">
                        <input type="hidden" id="txtStatusFormulario">
                        <input type="hidden" id="txtIdDenuncia">
                        <div class="form-row">
                            <div class="col-12 mb-3 d-flex align-items-center">
                                <h5 class="font-weight-light text-dark" id="txtPresuntoDenuncia"></h5>
                                <button type="button" class="btn btn-transparent text-warning" data-toggle="modal" data-target="#modalPresuntoDenuncia">
                                    <i class="far fa-lg fa-edit"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-4 col-md-6 col-12 offset-lg-4 offset-md-0 mb-3 d-none" id="contenedorNumExpediente">
                                <label for="fechaPresentacion">Número de expediente</label>
                                <input type="text" class="form-control" id="txtNumExpediente" required disabled>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Verifique el número de expediente
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 mb-3">
                                <label for="fechaPresentacion">Fecha de presentación de la denuncia</label>
                                <input type="date" class="form-control" id="txtFechaPresentacion" required disabled>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Verifique la fecha
                                </div>
                            </div>
                            <div class="col-12 text-center" id="contenedorSwitchCamposDenunciante">
                                <div class="form-group">
                                    <div class="custom-control custom-switch text-primary">
                                        <input type="checkbox" class="custom-control-input" id="mostrarInfoDenunciante" checked>
                                        <label class="custom-control-label text-primary font-weight-bolder" for="mostrarInfoDenunciante">¿Se conoce la identidad del denunciante?</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="contenedorInformacionDenunciante">
                            <div class="form-row">
                                <div class="col-4">
                                    <hr>
                                </div>
                                <div class="col-4 text-center">
                                    <h6 class="font-weight-light text-muted pt-2">Datos de la persona que presenta la denuncia</h6>
                                </div>
                                <div class="col-4">
                                    <hr>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-2 col-md-3 mb-3">
                                    <label for="txtAnonimatoDenunciante">¿Desea el anonimato?</label>
                                    <select class="custom-select" id="txtAnonimatoDenunciante" required>
                                        <option selected disabled value="">Elegir...</option>
                                        <option value="si">SI</option>
                                        <option value="no">NO</option>
                                    </select>
                                    <div class="valid-feedback">
                                        Correcto!
                                    </div>
                                    <div class="invalid-feedback">
                                        Elija una opción
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 mb-3">
                                    <label for="txtNombreDenunciante">Nombre</label>
                                    <input type="text" class="form-control" id="txtNombreDenunciante" required>
                                    <div class="valid-feedback">
                                        Correcto!
                                    </div>
                                    <div class="invalid-feedback">
                                        Verifique el nombre
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-5 mb-3">
                                    <label for="txtDomicilioDenunciante">Domicilio</label>
                                    <input type="text" class="form-control" id="txtDomicilioDenunciante" required>
                                    <div class="valid-feedback">
                                        Correcto!
                                    </div>
                                    <div class="invalid-feedback">
                                        Verifique el domicilio
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 mb-3">
                                    <label for="txtTelefonoDenunciante">Teléfono</label>
                                    <input type="tel" class="form-control" id="txtTelefonoDenunciante" pattern="[0-9]{10,15}" required>
                                    <div class="valid-feedback">
                                        Correcto!
                                    </div>
                                    <div class="invalid-feedback">
                                        Verifique el teléfono
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 mb-3">
                                    <label for="txtCorreoDenunciante">Correo electrónico</label>
                                    <input type="email" class="form-control" id="txtCorreoDenunciante" required>
                                    <div class="valid-feedback">
                                        Correcto!
                                    </div>
                                    <div class="invalid-feedback">
                                        Verifique el correo electrónico
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 mb-3">
                                    <label for="txtSexoDenunciante">Sexo</label>
                                    <select class="custom-select" id="txtSexoDenunciante" required>
                                        <option selected disabled value="">Elegir...</option>
                                        <option value="masculino">Masculino</option>
                                        <option value="femenino">Femenino</option>
                                    </select>
                                    <div class="valid-feedback">
                                        Correcto!
                                    </div>
                                    <div class="invalid-feedback">
                                        Elija una opción
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 mb-3">
                                    <label for="txtEdadDenunciante">Edad</label>
                                    <input type="number" class="form-control" id="txtEdadDenunciante" min="18" max="120" required>
                                    <div class="valid-feedback">
                                        Correcto!
                                    </div>
                                    <div class="invalid-feedback">
                                        Verifique la edad
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-6 mb-3">
                                    <label for="txtGradoEstudiosDenunciante">Grado de estudios</label>
                                    <input type="text" class="form-control" id="txtGradoEstudiosDenunciante" required>
                                    <div class="valid-feedback">
                                        Correcto!
                                    </div>
                                    <div class="invalid-feedback">
                                        Verifique el grado de estudios
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label for="txtDiscapacidadDenunciante">¿Vive con alguna discapacidad?</label>
                                    <input type="text" class="form-control" id="txtDiscapacidadDenunciante" required>
                                    <div class="valid-feedback">
                                        Correcto!
                                    </div>
                                    <div class="invalid-feedback">
                                        Responda la pregunta
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="txtSPDenunciante">¿Es una persona servidora pública?</label>
                                    <select class="custom-select" id="txtSPDenunciante" required>
                                        <option selected disabled value="">Elegir...</option>
                                        <option value="si">SI</option>
                                        <option value="no">NO</option>
                                    </select>
                                    <div class="valid-feedback">
                                        Correcto!
                                    </div>
                                    <div class="invalid-feedback">
                                        Elija una opción
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-6 mb-3 d-none" id="inputPuesto">
                                    <label for="txtPuestoDenunciante" class="text-white">L</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Puesto</div>
                                        </div>
                                        <input type="text" class="form-control" id="txtPuestoDenunciante" required>
                                        <div class="valid-feedback">
                                            Correcto!
                                        </div>
                                        <div class="invalid-feedback">
                                            Verifique el puesto
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-6 mb-3 d-none" id="inputEspecificar">
                                    <label for="txtEspecificarDenunciante" class="text-white">L</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Especifique:</div>
                                        </div>
                                        <input type="text" class="form-control" id="txtEspecificarDenunciante" required>
                                        <div class="valid-feedback">
                                            Correcto!
                                        </div>
                                        <div class="invalid-feedback">
                                            Especifíquese
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-3">
                                <hr>
                            </div>
                            <div class="col-6 text-center">
                                <h6 class="font-weight-light text-muted pt-2">Datos de la persona contra quien presenta la denuncia</h6>
                            </div>
                            <div class="col-3">
                                <hr>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-4 col-md-4 mb-3">
                                <label for="txtNombreDenunciado">Nombre</label>
                                <input type="text" class="form-control" id="txtNombreDenunciado" required>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Verifique el nombre
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 mb-3">
                                <label for="txtEntidadDenunciado">Entidad o dependencia en la que se desempeña</label>
                                <input type="text" class="form-control" id="txtEntidadDenunciado" required>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Verifique el dato
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 mb-3">
                                <label for="txtTelefonoDenunciado">Teléfono</label>
                                <input type="tel" class="form-control" id="txtTelefonoDenunciado" pattern="[0-9]{10,15}" required>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Verifique el teléfono
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 mb-3">
                                <label for="txtSexoDenunciado">Sexo</label>
                                <select class="custom-select" id="txtSexoDenunciado" required>
                                    <option selected disabled value="">Elegir...</option>
                                    <option value="masculino">Masculino</option>
                                    <option value="femenino">Femenino</option>
                                </select>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Elija una opción
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 mb-3">
                                <label for="txtEdadDenunciado">Edad</label>
                                <input type="number" class="form-control" id="txtEdadDenunciado" min="18" max="120" required>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Verifique la edad
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-3">
                                <label for="txtCorreoDenunciado">Correo electrónico</label>
                                <input type="email" class="form-control" id="txtCorreoDenunciado" required>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Verifique el correo electrónico
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-3">
                                <label for="txtSPDenunciado">¿Es una persona servidora pública?</label>
                                <select class="custom-select" id="txtSPDenunciado" required>
                                    <option selected disabled value="">Elegir...</option>
                                    <option value="si">SI</option>
                                    <option value="no">NO</option>
                                </select>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Elija una opción
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-3">
                                <label for="txtEspecificarDenunciado" class="text-white">L</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Especifique:</div>
                                    </div>
                                    <input type="text" class="form-control" id="txtEspecificarDenunciado" required>
                                    <div class="valid-feedback">
                                        Correcto!
                                    </div>
                                    <div class="invalid-feedback">
                                        Especifíquese
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 mb-3">
                                <label for="txtRelacionDenunciado">Relación con el denunciante</label>
                                <input type="text" class="form-control" id="txtRelacionDenunciado" required>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Verifique la relación con el denunciante
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-4">
                                <hr>
                            </div>
                            <div class="col-4 text-center">
                                <h6 class="font-weight-light text-muted pt-2">Información de la denuncia</h6>
                            </div>
                            <div class="col-4">
                                <hr>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 text-center">
                                <h6 class="font-weight-light text-muted pt-2">Ocurrió en:</h6>
                            </div>
                            <div class="col-lg-4 col-md-4 mb-3">
                                <label for="txtLugarDenuncia">Lugar</label>
                                <input type="text" class="form-control" id="txtLugarDenuncia" required>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Verifique el lugar
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 mb-3">
                                <label for="txtFechaDenuncia">Fecha</label>
                                <input type="date" class="form-control" id="txtFechaDenuncia" required>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Verifique la fecha
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 mb-3">
                                <label for="txtHoraDenuncia">Hora</label>
                                <input type="time" class="form-control" id="txtHoraDenuncia" required>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Verifique la hora
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="txtNarracionDenuncia">Breve narración del hecho o conducta</label>
                                <textarea class="form-control" id="txtNarracionDenuncia" rows="3" required></textarea>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Verifique la hora
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-3">
                                <hr>
                            </div>
                            <div class="col-6 text-center">
                                <h6 class="font-weight-light text-muted pt-2">Datos de la persona que haya sido testigo de los hechos</h6>
                            </div>
                            <div class="col-3">
                                <hr>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-4 col-md-4 mb-3">
                                <label for="txtNombreTestigo">Nombre</label>
                                <input type="text" class="form-control" id="txtNombreTestigo" required>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Verifique el nombre
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-5 mb-3">
                                <label for="txtDomicilioTestigo">Domicilio</label>
                                <input type="text" class="form-control" id="txtDomicilioTestigo" required>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Verifique el domicilio
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-3 mb-3">
                                <label for="txtTelefonoTestigo">Teléfono</label>
                                <input type="tel" class="form-control" id="txtTelefonoTestigo" pattern="[0-9]{10,15}" required>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Verifique el teléfono
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-3">
                                <label for="txtCorreoTestigo">Correo electrónico</label>
                                <input type="email" class="form-control" id="txtCorreoTestigo" required>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Verifique el correo electrónico
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-3">
                                <label for="txtRelacionTestigo">Relación con el denunciante</label>
                                <input type="text" class="form-control" id="txtRelacionTestigo" required>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Verifique el dato
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 offset-lg-0 offset-md-3 mb-3">
                                <label for="txtTrabajaTestigo">¿Trabaja en la administración pública estatal?</label>
                                <select class="custom-select" id="txtTrabajaTestigo" required>
                                    <option selected disabled value="">Elegir...</option>
                                    <option value="si">SI</option>
                                    <option value="no">NO</option>
                                </select>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Elija una opción
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-3 d-none" id="inputED">
                                <label for="txtEntidadTestigo" class="text-white">+</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Entidad o dependencia</div>
                                    </div>
                                    <input type="text" class="form-control" id="txtEntidadTestigo" required>
                                    <div class="valid-feedback">
                                        Correcto!
                                    </div>
                                    <div class="invalid-feedback">
                                        Verifique la entidad o dependencia
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-3 d-none" id="inputCargo">
                                <label for="txtCargoTestigo" class="text-white">+</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Cargo</div>
                                    </div>
                                    <input type="text" class="form-control" id="txtCargoTestigo" required>
                                    <div class="valid-feedback">
                                        Correcto!
                                    </div>
                                    <div class="invalid-feedback">
                                        Verifique el cargo
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <hr>
                            </div>
                        </div>
                        <div class="form-row justify-content-end">
                            <button class="btn btn-outline-dark" type="submit">
                                Guardar denuncia
                                <i class="fas fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-adminuser" role="tabpanel" aria-labelledby="nav-adminuser-tab">
            <div class="row align-items-center justify-content-center m-5">
                <div class="col-12">
                    <div class="card bg-white shadow" style="border: 0;">
                        <div class="card-body rounded" style="border-left: 5px solid #6fb430;border-top:0;border-right:0;border-bottom: 0;">
                            <form id="formAdministradorUser" class="needs-validation" novalidate>
                                <div class="row">
                                    <div id="Ad" class="tabcontent col-12" style="display: block;">
                                        <div class="row">
                                            <div class="col-12">
                                                <!-- Inicio cuerpo tabla -->
                                                <div id="tablePrintAdmins"></div>
                                                <!-- Fin cuerpo tabla -->
                                            </div>
                                        </div>
                                    </div>
                                    <div id="Us" class="tabcontent col-12">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="table-responsive" id="AdminMuestra"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-nuevaDenunciaImg" role="tabpanel" aria-labelledby="nav-nuevaDenunciaImg-tab">
            <div class="row align-items-center justify-content-center mx-1" style="min-height: 85vh;">
                <div class="card bg-white shadow my-3" style="width: 100vh; border: 0; border-left: 0; border-right: 0; border-bottom: 0;">
                    <div class="card-body rounded" style="border-top: 5px solid #b91926;">
                        <form id="formImgFormatoPresentacionDenuncia" class="needs-validation" novalidate>
                            <input type="hidden" id="txtImagenIdDenuncia" name="txtImagenIdDenuncia" required>
                            <input type="hidden" id="txtImagenPresunto" name="txtImagenPresunto" required>
                            <input type="hidden" id="txtImagenNumExpediente" name="txtImagenNumExpediente" required>
                            <input type="hidden" id="txtImagenFechaPresentacion" name="txtImagenFechaPresentacion" required>
                            <div class="form-row">
                                <div class="col-12 mb-3 d-flex align-items-center">
                                    <h6 class="font-weight-light text-dark pt-1 text-uppercase" id="txtImagenPresuntoDenuncia"></h6>
                                    <button type="button" class="btn btn-transparent ml-3 text-warning" data-toggle="modal" data-target="#modalPresuntoDenuncia">
                                        <i class="far fa-edit"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 col-12 mb-3 d-none" id="contenedorNumExpedienteImg">
                                    <label for="fechaPresentacion">Número de expediente</label>
                                    <input type="text" class="form-control" id="txtImagenNumExpedienteV" required disabled>
                                </div>
                                <div class="col-md-6 col-12 mb-3">
                                    <label for="fechaPresentacion">Fecha de presentación</label>
                                    <input type="date" class="form-control" id="txtImagenFechaPresentacionV" required disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Imagen de la denuncia</label>
                                        <div class="custom-file mb-3">
                                            <input type="file" class="custom-file-input" id="txtImagenDenuncia" name="txtImagenDenuncia" accept="image/png, .jpeg, .jpg, image/gif" lang="es" required>
                                            <label class="custom-file-label text-truncate" for="txtImagenDenuncia" id="labelImgDenuncia">Elegir imagen...</label>
                                            <div class="valid-feedback">Correcto!</div>
                                            <div class="invalid-feedback">Elija una imagen</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-3">
                                <div class="col-12 d-flex justify-content-center">
                                    <div id="contenedorImagen" class="px-1 text-center"></div>
                                </div>
                            </div>
                            <div class="form-row justify-content-between px-1">
                                <button class="btn btn-outline-danger" type="button" data-toggle="popover" data-placement="right" tabindex="0" data-trigger="focus" data-content="Asegurate de que el elemento que intentas subir tenga un peso menor a 2MB y contenga la totalidad de los datos requeridos en el formato para la presentación de una denuncia ante el comité de ética y de prevención de conflictos de interés de la oficicialía mayor. Usar esta opción solo permitirá un elemento por denuncia y se guardará como una denuncia pendiente de evaluación por los miembros del comité.">
                                    <i class="far fa-question-circle"></i>
                                </button>
                                <button class="btn btn-outline-dark" type="submit">
                                    Guardar denuncia
                                    <i class="fas fa-arrow-circle-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-nuevaDenunciaPDF" role="tabpanel" aria-labelledby="nav-nuevaDenunciaPDF-tab">
            <div class="row align-items-center justify-content-center mx-1" style="min-height: 85vh;">
                <div class="card bg-white shadow my-3" style="width: 100vh; border: 0; border-left: 0; border-right: 0; border-bottom: 0;">
                    <div class="card-body rounded" style="border-top: 5px solid #b91926;">
                        <form id="formPdfFormatoPresentacionDenuncia" class="needs-validation" novalidate>
                            <input type="hidden" id="txtIdDenunciaPDF" name="txtIdDenunciaPDF" required>
                            <input type="hidden" id="txtPresuntoPDF" name="txtPresuntoPDF" required>
                            <input type="hidden" id="txtNumExpedientePDF" name="txtNumExpedientePDF" required>
                            <input type="hidden" id="txtFechaPresentacionPDF" name="txtFechaPresentacionPDF" required>
                            <div class="form-row">
                                <div class="col-12 mb-3 d-flex align-items-center">
                                    <h6 class="font-weight-light text-dark pt-1 text-uppercase" id="txtPresuntoDenunciaPDF"></h6>
                                    <button type="button" class="btn btn-transparent ml-3 text-warning" data-toggle="modal" data-target="#modalPresuntoDenuncia">
                                        <i class="far fa-edit"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 col-12 mb-3 d-none" id="contenedorNumExpedientePDF">
                                    <label for="txtNumExpedientePDFV">Número de expediente</label>
                                    <input type="text" class="form-control" id="txtNumExpedientePDFV" required disabled>
                                </div>
                                <div class="col-md-6 col-12 mb-3">
                                    <label for="txtFechaPresentacionPDFV">Fecha de presentación</label>
                                    <input type="date" class="form-control" id="txtFechaPresentacionPDFV" required disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">PDF de la denuncia</label>
                                        <div class="custom-file mb-3">
                                            <input type="file" class="custom-file-input" id="txtDenunciaPDF" name="txtDenunciaPDF" accept=".pdf, .docx" lang="es" required>
                                            <label class="custom-file-label text-truncate" for="txtDenunciaPDF" id="labelDenunciaPDF">Elegir documento...</label>
                                            <div class="valid-feedback">Correcto!</div>
                                            <div class="invalid-feedback">Elija un documento</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-3">
                                <div class="col-12 d-flex justify-content-center">
                                    <div id="contenedorPDF" class="px-1 text-center"></div>
                                </div>
                            </div>
                            <div class="form-row justify-content-between px-1">
                                <button class="btn btn-outline-danger" type="button" data-toggle="popover" data-placement="right" tabindex="0" data-trigger="focus" data-content="Asegurate de que el elemento que intentas subir tenga un peso menor a 2MB y contenga la totalidad de los datos requeridos en el formato para la presentación de una denuncia ante el comité de ética y de prevención de conflictos de interés de la oficicialía mayor. Usar esta opción solo permitirá un elemento por denuncia y se guardará como una denuncia pendiente de evaluación por los miembros del comité.">
                                    <i class="far fa-question-circle"></i>
                                </button>
                                <button class="btn btn-outline-dark" type="submit">
                                    Guardar denuncia
                                    <i class="fas fa-arrow-circle-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-vizualizador" role="tabpanel" aria-labelledby="nav-vizualizador-tab">
            <form class="px-5 pb-3">
                <div class="form-row d-flex justify-content-between px-2">
                    <img src="vistas\static\img\logo_ofi.png" style="height: 5vh;">
                    <img src="vistas\static\img\Escudo_de_Armas_Oficial_del_Estado_de_Hidalgo.png" style="height: 5vh;width: 5vh;">
                </div>
                <div class="form-row">
                    <div class="col-12 py-2" style="color: #537F33;">
                        <h6 class="text-justify">FORMATO PARA LA PRESENTACIÓN DE UNA DENUNCIA ENTRE EL COMITÉ DE ÉTICA Y DE PREVENCIÓN DE CONFLICTOS DE INTERÉS DE LA OFICIALÍA MAYOR</h6>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 offset-lg-4 offset-md-0 mb-3">
                        <label for="fechaPresentacion">Número de expediente</label>
                        <input type="text" class="form-control form-control-sm" id="txtNumExpedienteV" disabled>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 mb-3">
                        <label for="fechaPresentacion">Fecha de presentación de la denuncia</label>
                        <input type="date" class="form-control form-control-sm" id="txtFechaPresentacionV" disabled>
                    </div>
                </div>
                <div id="contenedorDatosGenerales" class="d-none">
                    <div class="form-row">
                        <div class="col-12">
                            <h6 class="text-justify text-white text-center py-1" style="background-color: #39511D;">DATOS DE LA PERSONA QUE PRESENTA LA DENUNCIA</h6>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-lg-2 col-md-3 mb-3">
                            <label for="txtAnonimatoDenunciante">¿Desea el anonimato?</label>
                            <select class="custom-select custom-select-sm" id="txtAnonimatoDenuncianteV" disabled>
                                <option selected disabled value="">Elegir...</option>
                                <option value="si">SI</option>
                                <option value="no">NO</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 mb-3">
                            <label for="txtNombreDenunciante">Nombre</label>
                            <input type="text" class="form-control form-control-sm" id="txtNombreDenuncianteV" disabled>
                        </div>
                        <div class="col-lg-4 col-md-5 mb-3">
                            <label for="txtDomicilioDenunciante">Domicilio</label>
                            <input type="text" class="form-control form-control-sm" id="txtDomicilioDenuncianteV" disabled>
                        </div>
                        <div class="col-lg-2 col-md-3 mb-3">
                            <label for="txtTelefonoDenunciante">Teléfono</label>
                            <input type="tel" class="form-control form-control-sm" id="txtTelefonoDenuncianteV" disabled>
                        </div>
                        <div class="col-lg-3 col-md-4 mb-3">
                            <label for="txtCorreoDenunciante">Correo electrónico</label>
                            <input type="email" class="form-control form-control-sm" id="txtCorreoDenuncianteV" disabled>
                        </div>
                        <div class="col-lg-2 col-md-3 mb-3">
                            <label for="txtSexoDenunciante">Sexo</label>
                            <select class="custom-select custom-select-sm" id="txtSexoDenuncianteV" disabled>
                                <option selected disabled value="">Elegir...</option>
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                            </select>
                        </div>
                        <div class="col-lg-1 col-md-2 mb-3">
                            <label for="txtEdadDenunciante">Edad</label>
                            <input type="number" class="form-control form-control-sm" id="txtEdadDenuncianteV" disabled>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <label for="txtSPDenunciante">¿Es una persona servidora pública?</label>
                            <select class="custom-select custom-select-sm" id="txtSPDenuncianteV" disabled>
                                <option selected disabled value="">Elegir...</option>
                                <option value="si">SI</option>
                                <option value="no">NO</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3 d-none" id="inputPuestoV">
                            <label for="txtPuestoDenunciante" class="text-white">L</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Puesto</div>
                                </div>
                                <input type="text" class="form-control" id="txtPuestoDenuncianteV" disabled>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3 d-none" id="inputEspecificarV">
                            <label for="txtEspecificarDenunciante" class="text-white">L</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Especifique:</div>
                                </div>
                                <input type="text" class="form-control" id="txtEspecificarDenuncianteV" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-lg-6 col-md-6 mb-3">
                            <label for="txtGradoEstudiosDenunciante">Grado de estudios</label>
                            <input type="text" class="form-control form-control-sm" id="txtGradoEstudiosDenuncianteV" disabled>
                        </div>
                        <div class="col-lg-6 col-md-6 mb-3">
                            <label for="txtDiscapacidadDenunciante">¿Vive con alguna discapacidad?</label>
                            <input type="text" class="form-control form-control-sm" id="txtDiscapacidadDenuncianteV" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12">
                            <h6 class="text-justify text-white text-center py-1" style="background-color: #39511D;">DATOS DE LA PERSONA CONTRA QUIEN PRESENTA LA DENUNCIA</h6>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-lg-4 col-md-4 mb-3">
                            <label for="txtNombreDenunciado">Nombre</label>
                            <input type="text" class="form-control form-control-sm" id="txtNombreDenunciadoV" disabled>
                        </div>
                        <div class="col-lg-5 col-md-5 mb-3">
                            <label for="txtEntidadDenunciado">Entidad o dependencia en la que se desempeña</label>
                            <input type="text" class="form-control form-control-sm" id="txtEntidadDenunciadoV" disabled>
                        </div>
                        <div class="col-lg-3 col-md-3 mb-3">
                            <label for="txtTelefonoDenunciado">Teléfono</label>
                            <input type="tel" class="form-control form-control-sm" id="txtTelefonoDenunciadoV" disabled>
                        </div>
                        <div class="col-lg-3 col-md-5 mb-3">
                            <label for="txtCorreoDenunciado">Correo electrónico</label>
                            <input type="email" class="form-control form-control-sm" id="txtCorreoDenunciadoV" disabled>
                        </div>
                        <div class="col-lg-2 col-md-4 mb-3">
                            <label for="txtSexoDenunciado">Sexo</label>
                            <select class="custom-select custom-select-sm" id="txtSexoDenunciadoV" disabled>
                                <option selected disabled value="">Elegir...</option>
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                            </select>
                        </div>
                        <div class="col-lg-1 col-md-3 mb-3">
                            <label for="txtEdadDenunciado">Edad</label>
                            <input type="number" class="form-control form-control-sm" id="txtEdadDenunciadoV" disabled>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <label for="txtSPDenunciado">¿Es una persona servidora pública?</label>
                            <select class="custom-select custom-select-sm" id="txtSPDenunciadoV" disabled>
                                <option selected disabled value="">Elegir...</option>
                                <option value="si">SI</option>
                                <option value="no">NO</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <label for="txtEspecificarDenunciado" class="text-white">L</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Especifique:</div>
                                </div>
                                <input type="text" class="form-control" id="txtEspecificarDenunciadoV" disabled>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="txtRelacionDenunciado">Relación con el denunciante</label>
                            <input type="text" class="form-control form-control-sm" id="txtRelacionDenunciadoV" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12">
                            <h6 class="text-justify text-white text-center py-1" style="background-color: #39511D;">INFORMACIÓN DE LA DENUNCIA</h6>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 text-center">
                            <h6 class="font-weight-light text-muted">Ocurrió en:</h6>
                        </div>
                        <div class="col-lg-4 col-md-4 mb-3">
                            <label for="txtLugarDenuncia">Lugar</label>
                            <input type="text" class="form-control form-control-sm" id="txtLugarDenunciaV" disabled>
                        </div>
                        <div class="col-lg-4 col-md-4 mb-3">
                            <label for="txtFechaDenuncia">Fecha</label>
                            <input type="date" class="form-control form-control-sm" id="txtFechaDenunciaV" disabled>
                        </div>
                        <div class="col-lg-4 col-md-4 mb-3">
                            <label for="txtHoraDenuncia">Hora</label>
                            <input type="time" class="form-control form-control-sm" id="txtHoraDenunciaV" disabled>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="txtNarracionDenuncia">Breve narración del hecho o conducta</label>
                            <textarea class="form-control form-control-sm" id="txtNarracionDenunciaV" rows="3" disabled></textarea>
                        </div>
                        <div class="col-12">
                            <p class="text-muted text-justify border p-2" style="font-size: small;"><b>Nota:</b> Puede anexar la narración en un documento independiente o utilizar las páginas que le sean necesarias.</p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12">
                            <h6 class="text-justify text-white text-center py-1" style="background-color: #39511D;">DATOS DE LA PERSONA QUE HAYA SIDO TESTIGO DE LOS HECHOS</h6>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-lg-4 col-md-4 mb-3">
                            <label for="txtNombreTestigo">Nombre</label>
                            <input type="text" class="form-control form-control-sm" id="txtNombreTestigoV" disabled>
                        </div>
                        <div class="col-lg-4 col-md-5 mb-3">
                            <label for="txtDomicilioTestigo">Domicilio</label>
                            <input type="text" class="form-control form-control-sm" id="txtDomicilioTestigoV" disabled>
                        </div>
                        <div class="col-lg-4 col-md-3 mb-3">
                            <label for="txtTelefonoTestigo">Teléfono</label>
                            <input type="tel" class="form-control form-control-sm" id="txtTelefonoTestigoV" disabled>
                        </div>
                        <div class="col-lg-6 col-md-6 mb-3">
                            <label for="txtCorreoTestigo">Correo electrónico</label>
                            <input type="email" class="form-control form-control-sm" id="txtCorreoTestigoV" disabled>
                        </div>
                        <div class="col-lg-6 col-md-6 mb-3">
                            <label for="txtRelacionTestigo">Relación con el denunciante</label>
                            <input type="text" class="form-control form-control-sm" id="txtRelacionTestigoV" disabled>
                        </div>
                        <div class="col-lg-4 col-md-6 offset-lg-0 offset-md-3 mb-3">
                            <label for="txtTrabajaTestigo">¿Trabaja en la administración pública estatal?</label>
                            <select class="custom-select custom-select-sm" id="txtTrabajaTestigoV" disabled>
                                <option selected disabled value="">Elegir...</option>
                                <option value="si">SI</option>
                                <option value="no">NO</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3 d-none" id="inputEDV">
                            <label for="txtEntidadTestigo" class="text-white">+</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Entidad o dependencia</div>
                                </div>
                                <input type="text" class="form-control" id="txtEntidadTestigoV" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3 d-none" id="inputCargoV">
                            <label for="txtCargoTestigo" class="text-white">+</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Cargo</div>
                                </div>
                                <input type="text" class="form-control" id="txtCargoTestigoV" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="contenedorImagenGeneral" class="d-none">
                    <div class="form-row">
                        <div class="col-12 mb-1">
                            <h6 class="text-justify text-white text-center py-1" style="background-color: #39511D;">DATOS GENERALES DE LA DENUNCIA</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center mb-3" id="contenedorImagenFormato"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12">
                        <p class="text-muted text-justify border p-2" style="font-size: small;"><b>Nota:</b> Se hace de su conocimiento que es responsabilidad de los integrantes del Comité de Ética y de Prevención de Conflictos de Interés (CEPCI) de la Oficialía Mayor, proteger los datos personales que estén bajo custodia y sujetarse a lo establecido en las leyes correspondientes a la materia.</p>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="nav-acuse" role="tabpanel" aria-labelledby="nav-acuse-tab">
            <form class="px-5 pb-3">
                <div class="form-row d-flex justify-content-between px-2">
                    <img src="vistas\static\img\logo_ofi.png" style="height: 5vh;">
                    <img src="vistas\static\img\Escudo_de_Armas_Oficial_del_Estado_de_Hidalgo.png" style="height: 5vh;width: 5vh;">
                </div>
                <div class="form-row mb-3">
                    <div class="col-12 py-2" style="color: #537F33;">
                        <h4 class="text-justify text-center font-weight-bold">ACUSE DE RECIBO DE DENUNCIA PRESENTADA</h4>
                    </div>
                    <div class="col-12 ml-3 pr-4">
                        <div class="row">
                            <div class="col-lg-5 col-sm-6 col-12" style="background-color: #39511D;">
                                <h5 class="text-white text-center p-4 pt-5 mt-2">DATOS GENERALES DE LA DENUNCIA</h5>
                            </div>
                            <div class="col-lg-7 col-sm-6 col-12 my-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Número de expediente</div>
                                            </div>
                                            <input type="text" class="form-control" id="txtNumExpedienteAcuse" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Fecha de recepción</div>
                                            </div>
                                            <input type="text" class="form-control" id="txtFechaRecepcionAcuse" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Hora de recepción</div>
                                            </div>
                                            <input type="text" class="form-control" id="txtHoraRecepcionAcuse" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row mb-4">
                    <div class="col-12">
                        <h6 class="text-justify text-white text-center py-2" style="background-color: #39511D;">ELEMENTOS APORTADOS POR EL DENUNCIANTE</h6>
                    </div>
                    <div class="col-12">
                        <div id="contenedorDatosGeneralesAcuse" class="d-none">
                            <div class="form-row">
                                <div class="col-12">
                                    <h6 class="text-justify text-dark text-center py-1">DATOS DE LA PERSONA QUE PRESENTA LA DENUNCIA</h6>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-2 col-md-3 mb-3">
                                    <label for="txtAnonimatoDenuncianteA">¿Desea el anonimato?</label>
                                    <select class="custom-select custom-select-sm" id="txtAnonimatoDenuncianteA" disabled>
                                        <option selected disabled value="">Elegir...</option>
                                        <option value="si">SI</option>
                                        <option value="no">NO</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-4 mb-3">
                                    <label for="txtNombreDenuncianteA">Nombre</label>
                                    <input type="text" class="form-control form-control-sm" id="txtNombreDenuncianteA" disabled>
                                </div>
                                <div class="col-lg-4 col-md-5 mb-3">
                                    <label for="txtDomicilioDenuncianteA">Domicilio</label>
                                    <input type="text" class="form-control form-control-sm" id="txtDomicilioDenuncianteA" disabled>
                                </div>
                                <div class="col-lg-2 col-md-3 mb-3">
                                    <label for="txtTelefonoDenuncianteA">Teléfono</label>
                                    <input type="tel" class="form-control form-control-sm" id="txtTelefonoDenuncianteA" disabled>
                                </div>
                                <div class="col-lg-3 col-md-4 mb-3">
                                    <label for="txtCorreoDenuncianteA">Correo electrónico</label>
                                    <input type="email" class="form-control form-control-sm" id="txtCorreoDenuncianteA" disabled>
                                </div>
                                <div class="col-lg-2 col-md-3 mb-3">
                                    <label for="txtSexoDenuncianteA">Sexo</label>
                                    <select class="custom-select custom-select-sm" id="txtSexoDenuncianteA" disabled>
                                        <option selected disabled value="">Elegir...</option>
                                        <option value="masculino">Masculino</option>
                                        <option value="femenino">Femenino</option>
                                    </select>
                                </div>
                                <div class="col-lg-1 col-md-2 mb-3">
                                    <label for="txtEdadDenuncianteA">Edad</label>
                                    <input type="number" class="form-control form-control-sm" id="txtEdadDenuncianteA" disabled>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label for="txtSPDenuncianteA">¿Es una persona servidora pública?</label>
                                    <select class="custom-select custom-select-sm" id="txtSPDenuncianteA" disabled>
                                        <option selected disabled value="">Elegir...</option>
                                        <option value="si">SI</option>
                                        <option value="no">NO</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3 d-none" id="inputPuestoA">
                                    <label for="txtPuestoDenuncianteA" class="text-white">L</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Puesto</div>
                                        </div>
                                        <input type="text" class="form-control" id="txtPuestoDenuncianteA" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3 d-none" id="inputEspecificarA">
                                    <label for="txtEspecificarDenuncianteA" class="text-white">L</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Especifique:</div>
                                        </div>
                                        <input type="text" class="form-control" id="txtEspecificarDenuncianteA" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-6 col-md-6 mb-3">
                                    <label for="txtGradoEstudiosDenuncianteA">Grado de estudios</label>
                                    <input type="text" class="form-control form-control-sm" id="txtGradoEstudiosDenuncianteA" disabled>
                                </div>
                                <div class="col-lg-6 col-md-6 mb-3">
                                    <label for="txtDiscapacidadDenuncianteA">¿Vive con alguna discapacidad?</label>
                                    <input type="text" class="form-control form-control-sm" id="txtDiscapacidadDenuncianteA" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <h6 class="text-justify text-dark text-center py-1">DATOS DE LA PERSONA CONTRA QUIEN PRESENTA LA DENUNCIA</h6>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-4 col-md-4 mb-3">
                                    <label for="txtNombreDenunciadoA">Nombre</label>
                                    <input type="text" class="form-control form-control-sm" id="txtNombreDenunciadoA" disabled>
                                </div>
                                <div class="col-lg-5 col-md-5 mb-3">
                                    <label for="txtEntidadDenunciadoA">Entidad o dependencia en la que se desempeña</label>
                                    <input type="text" class="form-control form-control-sm" id="txtEntidadDenunciadoA" disabled>
                                </div>
                                <div class="col-lg-3 col-md-3 mb-3">
                                    <label for="txtTelefonoDenunciadoA">Teléfono</label>
                                    <input type="tel" class="form-control form-control-sm" id="txtTelefonoDenunciadoA" disabled>
                                </div>
                                <div class="col-lg-3 col-md-5 mb-3">
                                    <label for="txtCorreoDenunciadoA">Correo electrónico</label>
                                    <input type="email" class="form-control form-control-sm" id="txtCorreoDenunciadoA" disabled>
                                </div>
                                <div class="col-lg-2 col-md-4 mb-3">
                                    <label for="txtSexoDenunciadoA">Sexo</label>
                                    <select class="custom-select custom-select-sm" id="txtSexoDenunciadoA" disabled>
                                        <option selected disabled value="">Elegir...</option>
                                        <option value="masculino">Masculino</option>
                                        <option value="femenino">Femenino</option>
                                    </select>
                                </div>
                                <div class="col-lg-1 col-md-3 mb-3">
                                    <label for="txtEdadDenunciadoA">Edad</label>
                                    <input type="number" class="form-control form-control-sm" id="txtEdadDenunciadoA" disabled>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label for="txtSPDenunciadoA">¿Es una persona servidora pública?</label>
                                    <select class="custom-select custom-select-sm" id="txtSPDenunciadoA" disabled>
                                        <option selected disabled value="">Elegir...</option>
                                        <option value="si">SI</option>
                                        <option value="no">NO</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label for="txtEspecificarDenunciadoA" class="text-white">L</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Especifique:</div>
                                        </div>
                                        <input type="text" class="form-control" id="txtEspecificarDenunciadoA" disabled>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="txtRelacionDenunciadoA">Relación con el denunciante</label>
                                    <input type="text" class="form-control form-control-sm" id="txtRelacionDenunciadoA" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <h6 class="text-justify text-dark text-center py-1">INFORMACIÓN DE LA DENUNCIA</h6>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 text-center">
                                    <h6 class="font-weight-light text-muted">Ocurrió en:</h6>
                                </div>
                                <div class="col-lg-4 col-md-4 mb-3">
                                    <label for="txtLugarDenunciaA">Lugar</label>
                                    <input type="text" class="form-control form-control-sm" id="txtLugarDenunciaA" disabled>
                                </div>
                                <div class="col-lg-4 col-md-4 mb-3">
                                    <label for="txtFechaDenunciaA">Fecha</label>
                                    <input type="date" class="form-control form-control-sm" id="txtFechaDenunciaA" disabled>
                                </div>
                                <div class="col-lg-4 col-md-4 mb-3">
                                    <label for="txtHoraDenunciaA">Hora</label>
                                    <input type="time" class="form-control form-control-sm" id="txtHoraDenunciaA" disabled>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="txtNarracionDenunciaA">Breve narración del hecho o conducta</label>
                                    <textarea class="form-control form-control-sm" id="txtNarracionDenunciaA" rows="3" disabled></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <h6 class="text-justify text-dark text-center py-1">DATOS DE LA PERSONA QUE HAYA SIDO TESTIGO DE LOS HECHOS</h6>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-4 col-md-4 mb-3">
                                    <label for="txtNombreTestigoA">Nombre</label>
                                    <input type="text" class="form-control form-control-sm" id="txtNombreTestigoA" disabled>
                                </div>
                                <div class="col-lg-4 col-md-5 mb-3">
                                    <label for="txtDomicilioTestigoA">Domicilio</label>
                                    <input type="text" class="form-control form-control-sm" id="txtDomicilioTestigoA" disabled>
                                </div>
                                <div class="col-lg-4 col-md-3 mb-3">
                                    <label for="txtTelefonoTestigoA">Teléfono</label>
                                    <input type="tel" class="form-control form-control-sm" id="txtTelefonoTestigoA" disabled>
                                </div>
                                <div class="col-lg-6 col-md-6 mb-3">
                                    <label for="txtCorreoTestigoA">Correo electrónico</label>
                                    <input type="email" class="form-control form-control-sm" id="txtCorreoTestigoA" disabled>
                                </div>
                                <div class="col-lg-6 col-md-6 mb-3">
                                    <label for="txtRelacionTestigoA">Relación con el denunciante</label>
                                    <input type="text" class="form-control form-control-sm" id="txtRelacionTestigoA" disabled>
                                </div>
                                <div class="col-lg-4 col-md-6 offset-lg-0 offset-md-3 mb-3">
                                    <label for="txtTrabajaTestigoA">¿Trabaja en la administración pública estatal?</label>
                                    <select class="custom-select custom-select-sm" id="txtTrabajaTestigoA" disabled>
                                        <option selected disabled value="">Elegir...</option>
                                        <option value="si">SI</option>
                                        <option value="no">NO</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-3 d-none" id="inputEDA">
                                    <label for="txtEntidadTestigoA" class="text-white">+</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Entidad o dependencia</div>
                                        </div>
                                        <input type="text" class="form-control" id="txtEntidadTestigoA" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-3 d-none" id="inputCargoA">
                                    <label for="txtCargoTestigoA" class="text-white">+</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Cargo</div>
                                        </div>
                                        <input type="text" class="form-control" id="txtCargoTestigoA" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="contenedorImagenGeneralAcuse" class="d-none">
                            <div class="text-center" id="contenedorImagenFormatoAcuse"></div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12 mb-1">
                        <h6 class="text-justify text-white text-center py-2" style="background-color: #39511D;">OBSERVACIONES GENERALES</h6>
                    </div>
                    <div class="col-12 mb-3">
                        <textarea class="form-control form-control-sm" id="X" rows="5"></textarea>
                    </div>
                    <div class="col-12">
                        <p class="text-muted text-justify border p-2" style="font-size: small;"><b>Nota:</b> La circunstancia de presentar una denuncia, no otorga a la persona que la promueva el derecho de exigir una determinada actuación por parte del Comité de Ética y de Prevención de Conflictos de Interés de la Oficialía Mayor.</p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Agregar Usuario -->
    <div class="modal fade" id="newAdmin" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to right, #e63c4d,#b91926);">
                    <h5 class="modal-title text-white" id="exampleModalLongTitle">Agregar Usuario / Administrador</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" id="exit">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="newaddadmin">
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputForm01">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" aria-describedby="emailHelp" placeholder="Nombre">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputForm01">Apellido Paterno</label>
                                        <input type="text" class="form-control" id="app" aria-describedby="emailHelp" placeholder="Apellido Paterno">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputForm01">Apellido Materno</label>
                                        <input type="text" class="form-control" id="apm" aria-describedby="emailHelp" placeholder="Apellido Materno">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputForm02">Contraseña</label>
                                        <input type="password" class="form-control" id="pass" placeholder="Contraseña">
                                        <span style="font-size: 11px;" id="msj"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="inputForm01">Correo Electrónico</label>
                                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Correo">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputForm01">Teléfono</label>
                                        <input type="text" class="form-control" id="tel" aria-describedby="emailHelp" placeholder="Teléfono">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputForm03">Tipo Usuario</label>
                                        <select class="custom-select" id="tipou" required>
                                            <option disabled="true" selected="true">Seleccionar...</option>
                                            <option>Administrador</option>
                                            <option>Usuario Consulta</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" id="status" value="1" name="estadoUsuario">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary text-dark" data-dismiss="modal" id="exit">Salir</button>
                                <button type="submit" class="btn btn-outline-dark">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Usuario -->
    <div class="modal fade" id="editAdministrador" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to right, #e63c4d,#b91926);">
                    <h5 class="modal-title text-white" id="exampleModalLongTitle">Editar Usuario / Administrador</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" id="exit">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editaddadmin">
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputForm01">Nombre</label>
                                        <input type="hidden" id="input1">
                                        <input type="text" class="form-control" id="enombre" aria-describedby="emailHelp" placeholder="Nombre">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputForm01">Apellido Paterno</label>
                                        <input type="text" class="form-control" id="eapp" aria-describedby="emailHelp" placeholder="Apellido Paterno">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputForm01">Apellido Materno</label>
                                        <input type="text" class="form-control" id="eapm" aria-describedby="emailHelp" placeholder="Apellido Materno">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputForm02">Contraseña</label>
                                        <input type="password" class="form-control" id="epass" placeholder="Contraseña">
                                        <input type="hidden" id="defi">
                                        <span style="font-size: 11px;" id="msj2"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="inputForm01">Correo Electrónico</label>
                                        <input type="email" class="form-control" id="eemail" aria-describedby="emailHelp" placeholder="Correo">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputForm01">Teléfono</label>
                                        <input type="text" class="form-control" id="etel" aria-describedby="emailHelp" placeholder="Teléfono">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputForm03">Tipo Usuario</label>
                                        <select class="custom-select" id="etipou" required>
                                            <option disabled="true" selected="true">Seleccionar...</option>
                                            <option>Administrador</option>
                                            <option>Usuario Consulta</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary text-dark" data-dismiss="modal">Salir</button>
                                <button type="submit" class="btn btn-outline-dark">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tipo Denuncia -->
    <div class="modal fade" id="modalPresuntoDenuncia" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalPresuntoDenunciaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to right, #e63c4d,#b91926);">
                    <h5 class="modal-title text-white" id="modalPresuntoDenunciaLabel">La denuncia es por un presunto...</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background-color: #F0F4F7;">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 py-2">
                                    <div id="presunto1" class="card bg-white shadow-sm" style="border-left-color: #e63c4d; border-top: 0; border-right: 0; border-bottom: 0;">
                                        <div class="card-body text-center">
                                            <span class="font-weight-light">Incumplimiento al código de ética y de conducta</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 py-2">
                                    <div id="presunto2" class="card bg-white shadow-sm" style="border-left-color: #e63c4d; border-top: 0; border-right: 0; border-bottom: 0;">
                                        <div class="card-body text-center">
                                            <span class="font-weight-light">Incumplimiento a las reglas de integridad</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-12 py-2">
                                    <div id="presunto3" class="card bg-white shadow-sm" style="border-left-color: #e63c4d; border-top: 0; border-right: 0; border-bottom: 0;">
                                        <div class="card-body text-center">
                                            <span class="font-weight-light">Agresión</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12 py-2">
                                    <div id="presunto4" class="card bg-white shadow-sm" style="border-left-color: #e63c4d; border-top: 0; border-right: 0; border-bottom: 0;">
                                        <div class="card-body text-center">
                                            <span class="font-weight-light">Amedrentamiento</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12 py-2">
                                    <div id="presunto5" class="card bg-white shadow-sm" style="border-left-color: #e63c4d; border-top: 0; border-right: 0; border-bottom: 0;">
                                        <div class="card-body text-center">
                                            <span class="font-weight-light">Intimidación</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12 py-2">
                                    <div id="presunto6" class="card bg-white shadow-sm" style="border-left-color: #e63c4d; border-top: 0; border-right: 0; border-bottom: 0;">
                                        <div class="card-body text-center">
                                            <span class="font-weight-light">Amenazas</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Concluir Denuncia -->
    <div class="modal fade" id="modalConcluirDenuncia" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalConcluirDenunciaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to right, #e63c4d,#b91926);">
                    <h5 class="modal-title text-white" id="modalConcluirDenunciaLabel">Concluyendo denuncia</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-white">
                    <form id="formActaDenuncia" class="needs-validation" novalidate>
                        <input type="hidden" id="txtIdDenunciaActa" name="txtIdDenunciaActa" required>
                        <div class="form-row">
                            <div class="col-12 mb-3 d-flex align-items-center">
                                <ins>
                                    <h6 class="font-weight-light text-dark pt-1 text-uppercase" id="txtPresuntoDenunciaActa"></h6>
                                </ins>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 col-12 mb-3">
                                <label for="fechaPresentacion">Número de expediente</label>
                                <input type="text" class="form-control form-control-sm" id="txtNumExpedienteActa" required disabled>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="fechaPresentacion">Fecha de presentación</label>
                                <input type="date" class="form-control form-control-sm" id="txtFechaPresentacionActa" required disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Acta de la sesión</label>
                                    <div class="custom-file custom-file-sm mb-3">
                                        <input type="file" class="custom-file-input" id="txtActaDenunciaPDF" name="txtActaDenunciaPDF" accept=".pdf, .docx" lang="es" required>
                                        <label class="custom-file-label text-truncate" for="txtActaDenunciaPDF" id="labelActaDenunciaPDF">Elegir documento...</label>
                                        <div class="valid-feedback">Correcto!</div>
                                        <div class="invalid-feedback">Elija un documento</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="col-12 d-flex justify-content-center">
                                <div id="contenedorActaPDF" class="px-1 text-center"></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <p class="card bg-white shadow-sm text-justify p-2" style="border-left-color: #e63c4d; border-top: 0; border-right: 0; border-bottom: 0; font-size: small;"><b>Nota:</b> Al concluir con la denuncia no podrá volver a editarla, unicamente podrá vizualizarla y descargar el acta de la sesión !</p>
                            </div>
                        </div>
                        <div class="form-row justify-content-between px-1">
                            <button class="btn btn-outline-danger" type="button" data-toggle="popover" data-placement="right" tabindex="0" data-trigger="focus" data-content="Asegurate de que el elemento que intentas subir tenga un peso menor a 2MB y contenga la totalidad de los datos requeridos en el formato para la presentación de una denuncia ante el comité de ética y de prevención de conflictos de interés de la oficicialía mayor. Usar esta opción solo permitirá un elemento por denuncia.">
                                <i class="far fa-question-circle"></i>
                            </button>
                            <button class="btn btn-outline-dark" type="submit">
                                Guardar acta y concluir
                                <i class="fas fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Acta Denuncia -->
    <div class="modal fade" id="modalActaDenuncia" tabindex="-1" role="dialog" aria-labelledby="modalActaDenunciaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(to right, #e63c4d,#b91926);">
                    <h5 class="modal-title text-white" id="modalActaDenunciaLabel">Acta de la sesión</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-white">
                    <div class="row d-flex justify-content-center">
                        <div id="contenedorVizualizarActaPDF" class="px-1 text-center"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} else {
    header("Location: /AtencionADenuncias");
}
?>