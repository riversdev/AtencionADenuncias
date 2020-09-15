<?php
session_start();

if (isset($_SESSION['user_id'])) {
    require_once "modelos/modeloConexion.php";
    $idUsuario = $_SESSION['user_id'];
    $stmt = Conexion::conectar()->prepare("SELECT usuario FROM usuarios WHERE idUsuario='$idUsuario';");
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    $usuario = null;
    if (count($resultado) > 0) {
        $usuario = $resultado;
        $stmt = null;
    }
?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="/AtencionADenuncias">Atención a denuncias</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <div class="nav d-flex justify-content-center align-items-center" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-denuncias-tab" data-toggle="tab" href="#nav-denuncias" role="tab" aria-controls="nav-denuncias" aria-selected="true">
                        Denuncias
                    </a>
                    <a class="nav-item nav-link d-none" id="nav-nuevaDenunciaForm-tab" data-toggle="tab" href="#nav-nuevaDenunciaForm" role="tab" aria-controls="nav-nuevaDenunciaForm" aria-selected="false">
                        Nueva denuncia - Llenar formulario - Invisible
                    </a>
                    <a class="nav-item nav-link d-none" id="nav-nuevaDenunciaImg-tab" data-toggle="tab" href="#nav-nuevaDenunciaImg" role="tab" aria-controls="nav-nuevaDenunciaImg" aria-selected="false">
                        Nueva denuncia - Subir imagen - Invisible
                    </a>
                    <a class="nav-item nav-link d-none" id="nav-vizualizador-tab" data-toggle="tab" href="#nav-vizualizador" role="tab" aria-controls="nav-vizualizador" aria-selected="false">
                        vizualizador - Invisible
                    </a>
                </div>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="opcionDenuncia" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Nueva denuncia
                    </a>
                    <div class="dropdown-menu" aria-labelledby="opcionDenuncia">
                        <a class="dropdown-item" id="llenarFormulario">Llenar formulario</a>
                        <a class="dropdown-item" id="subirImagen">Subir imagen</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <button type="button" class="btn btn-outline-light d-none" id="btnImprimir">
                    <i class="fas fa-print"></i>
                </button>
                <div class="btn-group pl-3">
                    <button type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="far fa-user"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-item text-center bg-white">
                            <h5 class="text-primary"><?php echo $usuario['usuario']; ?></h5>
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
                </div>
            </div>
        </form>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-denuncias" role="tabpanel" aria-labelledby="nav-denuncias-tab">
            <div id="contenedorTablasDenuncias"></div>
        </div>
        <div class="tab-pane fade" id="nav-nuevaDenunciaForm" role="tabpanel" aria-labelledby="nav-nuevaDenunciaForm-tab">
            <div class="card bg-white border border-info border-top-0 border-bottom-0 border-right-0 shadow-sm bg-white rounded mx-5 my-3">
                <form id="formFormatoPresentacionDenuncia" class="needs-validation m-3" novalidate>
                    <input type="hidden" id="txtTareaFormulario">
                    <input type="hidden" id="txtStatusFormulario">
                    <input type="hidden" id="txtIdDenuncia">
                    <div class="form-row">
                        <div class="col-12 mb-3 d-flex align-items-center">
                            <h5 class="font-weight-light text-primary pt-1" id="txtPresuntoDenuncia"></h5>
                            <button type="button" class="btn btn-transparent ml-3 text-info" data-toggle="modal" data-target="#modalPresuntoDenuncia">
                                <i class="far fa-edit"></i>
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
                    </div>
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
                        <div class="col-lg-1 col-md-2 mb-3">
                            <label for="txtEdadDenunciante">Edad</label>
                            <input type="number" class="form-control" id="txtEdadDenunciante" min="18" max="120" required>
                            <div class="valid-feedback">
                                Correcto!
                            </div>
                            <div class="invalid-feedback">
                                Verifique la edad
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
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
                        <div class="col-lg-3 col-md-6 mb-3 d-none" id="inputPuesto">
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
                        <div class="col-lg-3 col-md-6 mb-3 d-none" id="inputEspecificar">
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
                    <div class="form-row">
                        <div class="col-lg-6 col-md-6 mb-3">
                            <label for="txtGradoEstudiosDenunciante">Grado de estudios</label>
                            <input type="text" class="form-control" id="txtGradoEstudiosDenunciante" required>
                            <div class="valid-feedback">
                                Correcto!
                            </div>
                            <div class="invalid-feedback">
                                Verifique el grado de estudios
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 mb-3">
                            <label for="txtDiscapacidadDenunciante">¿Vive con alguna discapacidad?</label>
                            <input type="text" class="form-control" id="txtDiscapacidadDenunciante" required>
                            <div class="valid-feedback">
                                Correcto!
                            </div>
                            <div class="invalid-feedback">
                                Responda la pregunta
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
                        <div class="col-lg-3 col-md-5 mb-3">
                            <label for="txtCorreoDenunciado">Correo electrónico</label>
                            <input type="email" class="form-control" id="txtCorreoDenunciado" required>
                            <div class="valid-feedback">
                                Correcto!
                            </div>
                            <div class="invalid-feedback">
                                Verifique el correo electrónico
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 mb-3">
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
                        <div class="col-lg-1 col-md-3 mb-3">
                            <label for="txtEdadDenunciado">Edad</label>
                            <input type="number" class="form-control" id="txtEdadDenunciado" min="18" max="120" required>
                            <div class="valid-feedback">
                                Correcto!
                            </div>
                            <div class="invalid-feedback">
                                Verifique la edad
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
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
                        <div class="col-lg-3 col-md-6 mb-3">
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
                        <div class="col-12 mb-3">
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
                        <button class="btn btn-primary" type="submit">
                            Guardar denuncia
                            <i class="fas fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-nuevaDenunciaImg" role="tabpanel" aria-labelledby="nav-nuevaDenunciaImg-tab">
            <div class="row align-items-center justify-content-center mx-1" style="min-height: 85vh;">
                <div class="card bg-white border border-info border-top-0 border-bottom-0 border-right-0 shadow-sm bg-white rounded my-3" style="max-width: 30rem;">
                    <div class="card-body">
                        <form id="formImgFormatoPresentacionDenuncia" class="needs-validation" novalidate>
                            <input type="hidden" id="txtImagenIdDenuncia" name="txtImagenIdDenuncia" required>
                            <input type="hidden" id="txtImagenPresunto" name="txtImagenPresunto" required>
                            <input type="hidden" id="txtImagenNumExpediente" name="txtImagenNumExpediente" required>
                            <input type="hidden" id="txtImagenFechaPresentacion" name="txtImagenFechaPresentacion" required>
                            <div class="form-row">
                                <div class="col-12 mb-3 d-flex align-items-center">
                                    <h6 class="font-weight-light text-primary pt-1 text-uppercase" id="txtImagenPresuntoDenuncia"></h6>
                                    <button type="button" class="btn btn-transparent ml-3 text-info" data-toggle="modal" data-target="#modalPresuntoDenuncia">
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
                                    <div class="custom-file mb-3">
                                        <input type="file" class="custom-file-input" id="txtImagenDenuncia" name="txtImagenDenuncia" accept="image/png, .jpeg, .jpg, image/gif" required>
                                        <label class="custom-file-label text-truncate" for="txtImagenDenuncia" id="labelImgDenuncia">Elegir imagen...</label>
                                        <div class="valid-feedback">Correcto!</div>
                                        <div class="invalid-feedback">Elija una imagen</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-3">
                                <div class="col-12 d-flex justify-content-center">
                                    <div id="contenedorImagen" class="px-1 text-center"></div>
                                </div>
                            </div>
                            <div class="form-row justify-content-between px-1">
                                <button class="btn btn-transparent text-info" type="button" data-toggle="modal" data-target="#modalAyuda">
                                    <i class="far fa-question-circle"></i>
                                </button>
                                <button class="btn btn-outline-primary" type="submit">
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
                    <img src="" style="height: 8vh;width: 8vh;">
                    <img src="vistas\static\img\Escudo_de_Armas_Oficial_del_Estado_de_Hidalgo.png" style="height: 8vh;width: 8vh;">
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
                    <div class="form-row">
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
    </div>

    <!-- Modal Tipo Denuncia -->
    <div class="modal fade" id="modalPresuntoDenuncia" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalPresuntoDenunciaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalPresuntoDenunciaLabel">La denuncia es por un presunto...</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background-color: #F0F4F7;">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-4 col-sm-6 col-12 py-2">
                                    <div id="presunto1" class="card bg-white border border-info border-top-0 border-bottom-0 border-right-0 shadow-sm bg-white rounded">
                                        <div class="card-body text-center">
                                            <span class="font-weight-light">Incumplimiento al código de ética</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12 py-2">
                                    <div id="presunto2" class="card bg-white border border-info border-top-0 border-bottom-0 border-right-0 shadow-sm bg-white rounded">
                                        <div class="card-body text-center">
                                            <span class="font-weight-light">Incumplimiento a las reglas de integridad</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12 py-2">
                                    <div id="presunto3" class="card bg-white border border-info border-top-0 border-bottom-0 border-right-0 shadow-sm bg-white rounded">
                                        <div class="card-body text-center">
                                            <span class="font-weight-light">Incumplimiento al código de conducta</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 col-12 py-2">
                                    <div id="presunto4" class="card bg-white border border-info border-top-0 border-bottom-0 border-right-0 shadow-sm bg-white rounded">
                                        <div class="card-body text-center">
                                            <span class="font-weight-light">Agresión</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12 py-2">
                                    <div id="presunto5" class="card bg-white border border-info border-top-0 border-bottom-0 border-right-0 shadow-sm bg-white rounded">
                                        <div class="card-body text-center">
                                            <span class="font-weight-light">Amedrentamiento</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12 py-2">
                                    <div id="presunto6" class="card bg-white border border-info border-top-0 border-bottom-0 border-right-0 shadow-sm bg-white rounded">
                                        <div class="card-body text-center">
                                            <span class="font-weight-light">Intimidación</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12 py-2">
                                    <div id="presunto7" class="card bg-white border border-info border-top-0 border-bottom-0 border-right-0 shadow-sm bg-white rounded">
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

    <!-- Modal Ayuda -->
    <div class="modal fade" id="modalAyuda" tabindex="-1" aria-labelledby="modalAyudaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-12">
                            <p class="card bg-white border border-info border-top-0 border-bottom-0 border-right-0 shadow-sm bg-white rounded text-justify p-2 border text-muted" style="font-size: small;"><b>Nota:</b> Asegurate de que la imagen que intentas subir tenga un peso menor a 2MB y contenga la totalidad de los datos requeridos en el formato para la presentación de una denuncia ante el comité de ética y de prevención de conflictos de interés de la oficicialía mayor. Usar esta opción solo permitirá una imagen por denuncia y se guardará como una denuncia pendiente de evaluación por los miembros del comité.</p>
                        </div>
                    </div>
                    <div class="form-row justify-content-end pr-1">
                        <button type="button" class="btn btn-sm btn-outline-info" data-dismiss="modal">Entendido</button>
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