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
            formato denuncia
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