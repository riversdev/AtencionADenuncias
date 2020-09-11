<?php
session_start();

if (isset($_SESSION['user_id'])) {
?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
                <div class="btn-group">
                    <button type="button" class="btn btn-transparent dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="far fa-user"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-item text-center">
                            <h5 class="text-dark">Usuario</h5>
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

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-denuncias" role="tabpanel" aria-labelledby="nav-denuncias-tab">
            <div class="row align-items-center justify-content-center mx-5">
                <div class="col-12 p-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Inconclusas</h5>
                            <div id="contenedorinconclusas"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 p-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pendientes</h5>
                            <div id="contenedorpendientes"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 p-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Concluidas</h5>
                            <div id="contenedorconcluidas"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-nuevaDenunciaForm" role="tabpanel" aria-labelledby="nav-nuevaDenunciaForm-tab">
            <form id="formFormatoPresentacionDenuncia" class="needs-validation px-5 pt-3 pb-5" novalidate>
                <div class="form-row">
                    <div class="col-lg-8 col-md-6 col-12 mb-3">
                        <h5 class="font-weight-light text-primary" id="txtPresuntoDenuncia"></h5>
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
                    <button class="btn btn-transparent text-muted mr-5" type="submit" onclick="deInformacionParcial(1)">
                        Guardar Información parcial
                        <i class="fas fa-arrow-circle-right"></i>
                    </button>
                    <button class="btn btn-primary" type="submit" onclick="deInformacionParcial(0)">
                        Guardar denuncia
                        <i class="fas fa-arrow-circle-right"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="nav-nuevaDenunciaImg" role="tabpanel" aria-labelledby="nav-nuevaDenunciaImg-tab">
            imagen denuncia
        </div>
    </div>

    <!-- Modal Tipo Denuncia -->
    <div class="modal fade" id="modalPresuntoDenuncia" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalPresuntoDenunciaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPresuntoDenunciaLabel">La denuncia es por un presunto...</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-4 col-sm-6 col-12 py-2">
                                    <div id="presunto1" class="card">
                                        <div class="card-body text-center">
                                            <span class="font-weight-light">Incumplimiento al código de ética</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12 py-2">
                                    <div id="presunto2" class="card">
                                        <div class="card-body text-center">
                                            <span class="font-weight-light">Incumplimiento a las reglas de integridad</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12 py-2">
                                    <div id="presunto3" class="card">
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
                                    <div id="presunto4" class="card">
                                        <div class="card-body text-center">
                                            <span class="font-weight-light">Agresión</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12 py-2">
                                    <div id="presunto5" class="card">
                                        <div class="card-body text-center">
                                            <span class="font-weight-light">Amedrentamiento</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12 py-2">
                                    <div id="presunto6" class="card">
                                        <div class="card-body text-center">
                                            <span class="font-weight-light">Intimidación</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12 py-2">
                                    <div id="presunto7" class="card">
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
<?php
} else {
    header("Location: /AtencionADenuncias");
}
?>