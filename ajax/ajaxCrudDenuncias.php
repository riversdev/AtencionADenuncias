<?php
require_once "../modelos/modeloCrudDenuncias.php";

$accion = (isset($_GET['accion'])) ? $_GET['accion'] : 'leer';

function nuevoExpediente()
{
    $anioActual = date("Y");
    $ultimoNumeroExpediente = CrudDenuncias::obtenerUltimoNumeroExpediente($anioActual);
    if (count($ultimoNumeroExpediente) != 0) {
        $ultimoExpediente = explode("-", $ultimoNumeroExpediente[0][0])[0];
        $nuevoExpediente = intval($ultimoExpediente) + 1;
        if ($nuevoExpediente <= 999) {
            if (strlen($nuevoExpediente) == 1) {
                return "00" . strval($nuevoExpediente) . "-" . $anioActual;
            } elseif (strlen($nuevoExpediente) == 2) {
                return "0" . strval($nuevoExpediente) . "-" . $anioActual;
            } else {
                return strval($nuevoExpediente) . "-" . $anioActual;
            }
        } else {
            echo "error|Imposible guardar una nueva denuncia este año. EL PROTOCOLO DE ATENCIÓN A DENUNCIAS POR LOS INCUMPLIMIENTOS DEL CÓDIGO DE ÉTICA DE LA ADMINISTRACIÓN PÚBLICA DEL ESTADO DE HIDALGO Y CÓDIGO DE CONDUCTA DE OFICIALÍA MAYOR, ASI COMO AL PROCEDIMIENTO PARA LA PRESENTACIÓN DE DENUNCIAS ANTE EL COMITÉ DE ÉTICA Y PREVENCIÓN DE CONFLICTOS DE INTERÉS (CEPCI) DE OFICIALIA MAYOR, punto 6, paso 2 determina un formato específico para el número de expediente, de guardar una nueva denuncia el expediente 1000-" . $anioActual . " no coincide con el formato solicitado.";
        }
    } else {
        return "001-" . $anioActual;
    }
}

switch ($accion) {
    case 'guardarInfo':
        $nuevoExpediente = nuevoExpediente();
        if (strlen($nuevoExpediente) > 8) {
            break;
        }
        CrudDenuncias::guardarInfo($_POST['txtStatusFormulario'], $_POST['txtTipoDenuncia'], $nuevoExpediente, $_POST['txtFechaPresentacion'], $_POST['txtAnonimatoDenunciante'], $_POST['txtNombreDenunciante'], $_POST['txtDomicilioDenunciante'], $_POST['txtTelefonoDenunciante'], $_POST['txtCorreoDenunciante'], $_POST['txtSexoDenunciante'], $_POST['txtEdadDenunciante'], $_POST['txtSPDenunciante'], $_POST['txtPuestoDenunciante'], $_POST['txtEspecificarDenunciante'], $_POST['txtGradoEstudiosDenunciante'], $_POST['txtDiscapacidadDenunciante'], $_POST['txtNombreDenunciado'], $_POST['txtEntidadDenunciado'], $_POST['txtTelefonoDenunciado'], $_POST['txtCorreoDenunciado'], $_POST['txtSexoDenunciado'], $_POST['txtEdadDenunciado'], $_POST['txtSPDenunciado'], $_POST['txtEspecificarDenunciado'], $_POST['txtRelacionDenunciado'], $_POST['txtLugarDenuncia'], $_POST['txtFechaDenuncia'], $_POST['txtHoraDenuncia'], $_POST['txtNarracionDenuncia'], $_POST['txtNombreTestigo'], $_POST['txtDomicilioTestigo'], $_POST['txtTelefonoTestigo'], $_POST['txtCorreoTestigo'], $_POST['txtRelacionTestigo'], $_POST['txtTrabajaTestigo'], $_POST['txtEntidadTestigo'], $_POST['txtCargoTestigo']);
        break;

    case 'guardarImg':
        $nuevoExpediente = nuevoExpediente();
        if (strlen($nuevoExpediente) > 8) {
            break;
        }
        if ($_FILES['txtImagenDenuncia']['error'] === 4) {
            die("error|No se cargó una imagen");
        } elseif ($_FILES['txtImagenDenuncia']['error'] === 1) {
            die("error|La imagen sobrepasa el limite de tamaño (2MB)");
        } elseif ($_FILES['txtImagenDenuncia']['error'] === 0) {
            $imagenBinaria = addslashes(file_get_contents($_FILES['txtImagenDenuncia']['tmp_name']));
            $nombreArchivo = $_FILES['txtImagenDenuncia']['name'];
            $extensiones = array('jpg', 'jpeg', 'gif', 'png', 'bmp');
            $extension = explode('.', $nombreArchivo);
            $extension = end($extension);
            $extension = strtolower($extension);
            if (!in_array($extension, $extensiones)) {
                die('error|Sólo elija imagenes con extensiones: ' . implode(', ', $extensiones));
            } else {
                CrudDenuncias::guardarImg($_POST['txtImagenPresunto'], $nuevoExpediente, $_POST['txtImagenFechaPresentacion'], $imagenBinaria);
            }
        } else {
            die("error|Verifique sus datos");
        }
        break;

    case 'guardarPDF':
        $nuevoExpediente = nuevoExpediente();
        if (strlen($nuevoExpediente) > 8) {
            break;
        }
        if ($_FILES['txtDenunciaPDF']['error'] === 4) {
            die("error|No se cargó un documento");
        } elseif ($_FILES['txtDenunciaPDF']['error'] === 1) {
            die("error|El documento sobrepasa el limite de tamaño (2MB)");
        } elseif ($_FILES['txtDenunciaPDF']['error'] === 0) {
            $documentoBinario = addslashes(file_get_contents($_FILES['txtDenunciaPDF']['tmp_name']));
            $nombreArchivo = $_FILES['txtDenunciaPDF']['name'];
            $extensiones = array('pdf', 'doc', 'docx');
            $extension = explode('.', $nombreArchivo);
            $extension = end($extension);
            $extension = strtolower($extension);
            if (!in_array($extension, $extensiones)) {
                die('error|Sólo elija imagenes con extensiones: ' . implode(', ', $extensiones));
            } else {
                CrudDenuncias::guardarPdf($_POST['txtPresuntoPDF'], $nuevoExpediente, $documentoBinario);
            }
        } else {
            die("error|Verifique sus datos");
        }
        break;

    case 'editarInfo':
        CrudDenuncias::editarInfo($_POST['txtIdDenuncia'], $_POST['txtStatusFormulario'], $_POST['txtTipoDenuncia'], $_POST['txtNumExpediente'], $_POST['txtFechaPresentacion'], $_POST['txtAnonimatoDenunciante'], $_POST['txtNombreDenunciante'], $_POST['txtDomicilioDenunciante'], $_POST['txtTelefonoDenunciante'], $_POST['txtCorreoDenunciante'], $_POST['txtSexoDenunciante'], $_POST['txtEdadDenunciante'], $_POST['txtSPDenunciante'], $_POST['txtPuestoDenunciante'], $_POST['txtEspecificarDenunciante'], $_POST['txtGradoEstudiosDenunciante'], $_POST['txtDiscapacidadDenunciante'], $_POST['txtNombreDenunciado'], $_POST['txtEntidadDenunciado'], $_POST['txtTelefonoDenunciado'], $_POST['txtCorreoDenunciado'], $_POST['txtSexoDenunciado'], $_POST['txtEdadDenunciado'], $_POST['txtSPDenunciado'], $_POST['txtEspecificarDenunciado'], $_POST['txtRelacionDenunciado'], $_POST['txtLugarDenuncia'], $_POST['txtFechaDenuncia'], $_POST['txtHoraDenuncia'], $_POST['txtNarracionDenuncia'], $_POST['txtNombreTestigo'], $_POST['txtDomicilioTestigo'], $_POST['txtTelefonoTestigo'], $_POST['txtCorreoTestigo'], $_POST['txtRelacionTestigo'], $_POST['txtTrabajaTestigo'], $_POST['txtEntidadTestigo'], $_POST['txtCargoTestigo']);
        break;

    case 'editarImg':
        if ($_FILES['txtImagenDenuncia']['error'] === 4) {
            CrudDenuncias::editarImgSinImg($_POST['txtImagenIdDenuncia'], $_POST['txtImagenPresunto'], $_POST['txtImagenNumExpediente'], $_POST['txtImagenFechaPresentacion']);
        } elseif ($_FILES['txtImagenDenuncia']['error'] === 1) {
            die("error|La imagen sobrepasa el limite de tamaño (2MB)");
        } elseif ($_FILES['txtImagenDenuncia']['error'] === 0) {
            $imagenBinaria = addslashes(file_get_contents($_FILES['txtImagenDenuncia']['tmp_name']));
            $nombreArchivo = $_FILES['txtImagenDenuncia']['name'];
            $extensiones = array('jpg', 'jpeg', 'gif', 'png', 'bmp');
            $extension = explode('.', $nombreArchivo);
            $extension = end($extension);
            $extension = strtolower($extension);
            if (!in_array($extension, $extensiones)) {
                die('error|Sólo elija imagenes con extensiones: ' . implode(', ', $extensiones));
            } else {
                CrudDenuncias::editarImg($_POST['txtImagenIdDenuncia'], $_POST['txtImagenPresunto'], $_POST['txtImagenNumExpediente'], $_POST['txtImagenFechaPresentacion'], $imagenBinaria);
            }
        } else {
            die("error|Verifique sus datos");
        }
        break;

    case 'editarPDF':
        if ($_FILES['txtDenunciaPDF']['error'] === 4) {
            CrudDenuncias::editarPdfSinPdf($_POST['txtIdDenunciaPDF'], $_POST['txtPresuntoPDF'], $_POST['txtNumExpedientePDF']);
        } elseif ($_FILES['txtDenunciaPDF']['error'] === 1) {
            die("error|El documento sobrepasa el limite de tamaño (2MB)");
        } elseif ($_FILES['txtDenunciaPDF']['error'] === 0) {
            $documentoBinario = addslashes(file_get_contents($_FILES['txtDenunciaPDF']['tmp_name']));
            $nombreArchivo = $_FILES['txtDenunciaPDF']['name'];
            $extensiones = array('pdf', 'doc', 'docx');
            $extension = explode('.', $nombreArchivo);
            $extension = end($extension);
            $extension = strtolower($extension);
            if (!in_array($extension, $extensiones)) {
                die('error|Sólo elija documentos con extensiones: ' . implode(', ', $extensiones));
            } else {
                CrudDenuncias::editarPdf($_POST['txtIdDenunciaPDF'], $_POST['txtPresuntoPDF'], $_POST['txtNumExpedientePDF'], $documentoBinario);
            }
        } else {
            die("error|Verifique sus datos");
        }
        break;

    case 'concluirDenuncia':
        CrudDenuncias::concluirDenuncia($_POST['txtIdDenuncia']);
        break;

    case 'verificarInconclusas':
        CrudDenuncias::verificarDenunciasInconclusas($_POST['fechaVerificar'], $_POST['fechaActual']);
        break;

    case 'concluirSinSeguimiento':
        if (count(CrudDenuncias::buscarSinSeguimiento($_POST['fechaVerificar'])) != 0) {
            if (CrudDenuncias::concluirDenunciasSinSeguimiento($_POST['fechaVerificar'])) {
                echo "warning|Se concluyeron denuncias sin seguimiento !";
            } else {
                echo "error|Imposible concluir denuncias sin seguimiento !";
            }
        } else {
            echo "success|No existen denuncias sin seguimiento !";
        }
        break;

    default:
        $denunciasInconclusas = CrudDenuncias::obtenerDenuncias("inconclusa");
        $denunciasPendientes = CrudDenuncias::obtenerDenuncias("pendiente");
        $denunciasConcluidas = CrudDenuncias::obtenerDenuncias("concluida");
        if (count($denunciasInconclusas) == 0 && count($denunciasPendientes) == 0 && count($denunciasConcluidas) == 0) {
            echo '
                <div class="row d-flex justify-content-center align-items-center mx-1" style="height: 85vh;">
                    <div class="card bg-primary shadow-sm" style="max-width: 25rem;">
                        <div class="card-body text-white">
                            <h5 class="card-title text-center">Bienvenido</h5>
                            <p class="card-text text-justify">
                                <b>No existen denuncias,</b> puede comenzar a agregar nuevas eligiendo la opción en la navegación superior.
                            </p>
                        </div>
                    </div>
                </div>
            ';
        } else {
            echo '<div class="row align-items-center justify-content-center mx-5"><span class="py-3 text-light">.</span>';
            if (count($denunciasInconclusas) != 0) {
                echo '
                <div class="col-12">
                    <div class="card bg-white border border-primary border-top-0 border-bottom-0 border-right-0 shadow-sm rounded">
                        <div class="card-body">
                            <h6 class="card-title text-primary font-weight-bold">INCONCLUSAS</h6>
                            <table id="tablaInconclusas" class="table table-sm table-hover" style="width: 100%;">
                                <thead class="text-white" style="background: linear-gradient(to right, #243B55,#141E30);">
                                    <tr>
                                        <th scope="col">idDenuncia</th>
                                        <th scope="col">tipoDenuncia</th>
                                        <th scope="col" class="text-center"># Expediente</th>
                                        <th scope="col" class="text-center">Fecha de presentación</th>
                                        <th scope="col">anonimatoDenunciante</th>
                                        <th scope="col">Denunciante</th>
                                        <th scope="col">domicilioDenunciante</th>
                                        <th scope="col">telefonoDenunciante</th>
                                        <th scope="col">correoDenunciante</th>
                                        <th scope="col">sexoDenunciante</th>
                                        <th scope="col">edadDenunciante</th>
                                        <th scope="col">servidorPublicoDenunciante</th>
                                        <th scope="col">puestoDenunciante</th>
                                        <th scope="col">especificarDenunciante</th>
                                        <th scope="col">gradoEstudiosDenunciante</th>
                                        <th scope="col">discapacidadDenunciante</th>
                                        <th scope="col">Denunciado</th>
                                        <th scope="col">entidadDenunciado</th>
                                        <th scope="col">telefonoDenunciado</th>
                                        <th scope="col">correoDenunciado</th>
                                        <th scope="col">sexoDenunciado</th>
                                        <th scope="col">edadDenunciado</th>
                                        <th scope="col">servidorPublicoDenunciado</th>
                                        <th scope="col">especificarDenunciado</th>
                                        <th scope="col">relacionDenunciado</th>
                                        <th scope="col">lugarDenuncia</th>
                                        <th scope="col">fechaDenuncia</th>
                                        <th scope="col">horaDenuncia</th>
                                        <th scope="col">narracionDenuncia</th>
                                        <th scope="col">Testigo</th>
                                        <th scope="col">domicilioTestigo</th>
                                        <th scope="col">telefonoTestigo</th>
                                        <th scope="col">correoTestigo</th>
                                        <th scope="col">relacionTestigo</th>
                                        <th scope="col">trabajaTestigo</th>
                                        <th scope="col">entidadTestigo</th>
                                        <th scope="col">cargoTestigo</th>
                                        <th scope="col">statusDenuncia</th>
                                        <th scope="col" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>';
                foreach ($denunciasInconclusas as $row) {
                    echo '                  <tr style="font-size:small;">
                                        <td>' . $row['idDenuncia'] . '</td>
                                        <td>' . $row['tipoDenuncia'] . '</td>
                                        <th scope="row" class="text-center">' . $row['numExpediente'] . '</th>
                                        <td class="text-center">' . date("d-m-Y", strtotime($row['fechaPresentacion'])) . '</td>
                                        <td>' . $row['anonimatoDenunciante'] . '</td>
                                        <td>' . $row['nombreDenunciante'] . '</td>
                                        <td>' . $row['domicilioDenunciante'] . '</td>
                                        <td>' . $row['telefonoDenunciante'] . '</td>
                                        <td>' . $row['correoDenunciante'] . '</td>
                                        <td>' . $row['sexoDenunciante'] . '</td>
                                        <td>' . $row['edadDenunciante'] . '</td>
                                        <td>' . $row['servidorPublicoDenunciante'] . '</td>
                                        <td>' . $row['puestoDenunciante'] . '</td>
                                        <td>' . $row['especificarDenunciante'] . '</td>
                                        <td>' . $row['gradoEstudiosDenunciante'] . '</td>
                                        <td>' . $row['discapacidadDenunciante'] . '</td>';
                    if ($row['nombreDenunciado'] != "") {
                        echo '                  <td>' . $row['nombreDenunciado'] . '</td>';
                    } else {
                        echo '                  <td class="text-success" style="font-size:x-small;"> - - - - - - - </td>';
                    }
                    echo '                      <td>' . $row['entidadDenunciado'] . '</td>
                                        <td>' . $row['telefonoDenunciado'] . '</td>
                                        <td>' . $row['correoDenunciado'] . '</td>
                                        <td>' . $row['sexoDenunciado'] . '</td>
                                        <td>' . $row['edadDenunciado'] . '</td>
                                        <td>' . $row['servidorPublicoDenunciado'] . '</td>
                                        <td>' . $row['especificarDenunciado'] . '</td>
                                        <td>' . $row['relacionDenunciado'] . '</td>
                                        <td>' . $row['lugarDenuncia'] . '</td>
                                        <td>' . $row['fechaDenuncia'] . '</td>
                                        <td>' . $row['horaDenuncia'] . '</td>
                                        <td>' . $row['narracionDenuncia'] . '</td>
                                        <td>' . $row['nombreTestigo'] . '</td>
                                        <td>' . $row['domicilioTestigo'] . '</td>
                                        <td>' . $row['telefonoTestigo'] . '</td>
                                        <td>' . $row['correoTestigo'] . '</td>
                                        <td>' . $row['relacionTestigo'] . '</td>
                                        <td>' . $row['trabajaTestigo'] . '</td>
                                        <td>' . $row['entidadTestigo'] . '</td>
                                        <td>' . $row['cargoTestigo'] . '</td>
                                        <td>' . $row['statusDenuncia'] . '</td>
                                        <td class="d-flex justify-content-around">
                                            <i class="far fa-edit" onclick="prepararParaEditar(' . "
                                                '" . $row['idDenuncia'] . "',
                                                '" . $row['tipoDenuncia'] . "',
                                                '" . $row['numExpediente'] . "',
                                                '" . date("Y-m-d", strtotime($row['fechaPresentacion'])) . "',
                                                '" . base64_encode($row['imagenDenuncia']) . "',
                                                '" . $row['anonimatoDenunciante'] . "',
                                                '" . $row['nombreDenunciante'] . "',
                                                '" . $row['domicilioDenunciante'] . "',
                                                '" . $row['telefonoDenunciante'] . "',
                                                '" . $row['correoDenunciante'] . "',
                                                '" . $row['sexoDenunciante'] . "',
                                                '" . $row['edadDenunciante'] . "',
                                                '" . $row['servidorPublicoDenunciante'] . "',
                                                '" . $row['puestoDenunciante'] . "',
                                                '" . $row['especificarDenunciante'] . "',
                                                '" . $row['gradoEstudiosDenunciante'] . "',
                                                '" . $row['discapacidadDenunciante'] . "',
                                                '" . $row['nombreDenunciado'] . "',
                                                '" . $row['entidadDenunciado'] . "',
                                                '" . $row['telefonoDenunciado'] . "',
                                                '" . $row['correoDenunciado'] . "',
                                                '" . $row['sexoDenunciado'] . "',
                                                '" . $row['edadDenunciado'] . "',
                                                '" . $row['servidorPublicoDenunciado'] . "',
                                                '" . $row['especificarDenunciado'] . "',
                                                '" . $row['relacionDenunciado'] . "',
                                                '" . $row['lugarDenuncia'] . "',
                                                '" . $row['fechaDenuncia'] . "',
                                                '" . $row['horaDenuncia'] . "',
                                                '" . preg_replace("/[\r\n|\n|\r]+/", " ", $row['narracionDenuncia']) . "',
                                                '" . $row['nombreTestigo'] . "',
                                                '" . $row['domicilioTestigo'] . "',
                                                '" . $row['telefonoTestigo'] . "',
                                                '" . $row['correoTestigo'] . "',
                                                '" . $row['relacionTestigo'] . "',
                                                '" . $row['trabajaTestigo'] . "',
                                                '" . $row['entidadTestigo'] . "',
                                                '" . $row['cargoTestigo'] . "',
                                                '" . $row['statusDenuncia'] . "'
                                            " . ');"></i>
                                            <i class="far fa-eye" onclick="prepararParaVizualizar(' . "
                                                '" . $row['tipoDenuncia'] . "',
                                                '" . $row['numExpediente'] . "',
                                                '" . date("Y-m-d", strtotime($row['fechaPresentacion'])) . "',
                                                '" . base64_encode($row['imagenDenuncia']) . "',
                                                '" . $row['anonimatoDenunciante'] . "',
                                                '" . $row['nombreDenunciante'] . "',
                                                '" . $row['domicilioDenunciante'] . "',
                                                '" . $row['telefonoDenunciante'] . "',
                                                '" . $row['correoDenunciante'] . "',
                                                '" . $row['sexoDenunciante'] . "',
                                                '" . $row['edadDenunciante'] . "',
                                                '" . $row['servidorPublicoDenunciante'] . "',
                                                '" . $row['puestoDenunciante'] . "',
                                                '" . $row['especificarDenunciante'] . "',
                                                '" . $row['gradoEstudiosDenunciante'] . "',
                                                '" . $row['discapacidadDenunciante'] . "',
                                                '" . $row['nombreDenunciado'] . "',
                                                '" . $row['entidadDenunciado'] . "',
                                                '" . $row['telefonoDenunciado'] . "',
                                                '" . $row['correoDenunciado'] . "',
                                                '" . $row['sexoDenunciado'] . "',
                                                '" . $row['edadDenunciado'] . "',
                                                '" . $row['servidorPublicoDenunciado'] . "',
                                                '" . $row['especificarDenunciado'] . "',
                                                '" . $row['relacionDenunciado'] . "',
                                                '" . $row['lugarDenuncia'] . "',
                                                '" . $row['fechaDenuncia'] . "',
                                                '" . $row['horaDenuncia'] . "',
                                                '" . preg_replace("/[\r\n|\n|\r]+/", " ", $row['narracionDenuncia']) . "',
                                                '" . $row['nombreTestigo'] . "',
                                                '" . $row['domicilioTestigo'] . "',
                                                '" . $row['telefonoTestigo'] . "',
                                                '" . $row['correoTestigo'] . "',
                                                '" . $row['relacionTestigo'] . "',
                                                '" . $row['trabajaTestigo'] . "',
                                                '" . $row['entidadTestigo'] . "',
                                                '" . $row['cargoTestigo'] . "',
                                                '" . $row['statusDenuncia'] . "'
                                            " . ');"></i>
                                        </td>
                                    </tr>';
                }
                echo '          </tbody>
                            </table>
                        </div>
                    </div>
                </div>';
            }
            if (count($denunciasPendientes) != 0) {
                echo '
                <span class="py-3 text-light">.</span>
                <div class="col-12">
                    <div class="card bg-white border border-primary border-top-0 border-bottom-0 border-right-0 shadow-sm bg-white rounded">
                        <div class="card-body">
                            <h6 class="card-title text-primary font-weight-bold">PENDIENTES</h6>
                            <table id="tablaPendientes" class="table table-sm table-hover" style="width: 100%;">
                                <thead class="text-white" style="background: linear-gradient(to right, #243B55,#141E30);">
                                    <tr>
                                        <th scope="col">idDenuncia</th>
                                        <th scope="col">tipoDenuncia</th>
                                        <th scope="col" class="text-center"># Expediente</th>
                                        <th scope="col" class="text-center">Fecha de presentación</th>
                                        <th scope="col">anonimatoDenunciante</th>
                                        <th scope="col">Denunciante</th>
                                        <th scope="col">domicilioDenunciante</th>
                                        <th scope="col">telefonoDenunciante</th>
                                        <th scope="col">correoDenunciante</th>
                                        <th scope="col">sexoDenunciante</th>
                                        <th scope="col">edadDenunciante</th>
                                        <th scope="col">servidorPublicoDenunciante</th>
                                        <th scope="col">puestoDenunciante</th>
                                        <th scope="col">especificarDenunciante</th>
                                        <th scope="col">gradoEstudiosDenunciante</th>
                                        <th scope="col">discapacidadDenunciante</th>
                                        <th scope="col">Denunciado</th>
                                        <th scope="col">entidadDenunciado</th>
                                        <th scope="col">telefonoDenunciado</th>
                                        <th scope="col">correoDenunciado</th>
                                        <th scope="col">sexoDenunciado</th>
                                        <th scope="col">edadDenunciado</th>
                                        <th scope="col">servidorPublicoDenunciado</th>
                                        <th scope="col">especificarDenunciado</th>
                                        <th scope="col">relacionDenunciado</th>
                                        <th scope="col">lugarDenuncia</th>
                                        <th scope="col">fechaDenuncia</th>
                                        <th scope="col">horaDenuncia</th>
                                        <th scope="col">narracionDenuncia</th>
                                        <th scope="col">Testigo</th>
                                        <th scope="col">domicilioTestigo</th>
                                        <th scope="col">telefonoTestigo</th>
                                        <th scope="col">correoTestigo</th>
                                        <th scope="col">relacionTestigo</th>
                                        <th scope="col">trabajaTestigo</th>
                                        <th scope="col">entidadTestigo</th>
                                        <th scope="col">cargoTestigo</th>
                                        <th scope="col">statusDenuncia</th>
                                        <th scope="col" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>';
                foreach ($denunciasPendientes as $row) {
                    echo '          <tr style="font-size:small;">
                                        <td>' . $row['idDenuncia'] . '</td>
                                        <td>' . $row['tipoDenuncia'] . '</td>
                                        <th scope="row" class="text-center">' . $row['numExpediente'] . '</th>
                                        <td class="text-center">' . date("d-m-Y", strtotime($row['fechaPresentacion'])) . '</td>
                                        <td>' . $row['anonimatoDenunciante'] . '</td>';
                    if ($row['nombreDenunciante'] != "") {
                        echo '                  <td>' . $row['nombreDenunciante'] . '</td>';
                    } else {
                        if (base64_encode($row['imagenDenuncia']) != "") {
                            echo '              <td class="text-success" style="font-size:x-small;"> contiene imagen </td>';
                        } else {
                            echo '              <td class="text-success" style="font-size:x-small;"> denunciante desconocido </td>';
                        }
                    }
                    echo '                      <td>' . $row['domicilioDenunciante'] . '</td>
                                        <td>' . $row['telefonoDenunciante'] . '</td>
                                        <td>' . $row['correoDenunciante'] . '</td>
                                        <td>' . $row['sexoDenunciante'] . '</td>
                                        <td>' . $row['edadDenunciante'] . '</td>
                                        <td>' . $row['servidorPublicoDenunciante'] . '</td>
                                        <td>' . $row['puestoDenunciante'] . '</td>
                                        <td>' . $row['especificarDenunciante'] . '</td>
                                        <td>' . $row['gradoEstudiosDenunciante'] . '</td>
                                        <td>' . $row['discapacidadDenunciante'] . '</td>';
                    if ($row['nombreDenunciado'] != "") {
                        echo '                  <td>' . $row['nombreDenunciado'] . '</td>';
                    } else {
                        echo '                  <td class="text-success" style="font-size:x-small;"> contiene imagen </td>';
                    }
                    echo '                      <td>' . $row['entidadDenunciado'] . '</td>
                                        <td>' . $row['telefonoDenunciado'] . '</td>
                                        <td>' . $row['correoDenunciado'] . '</td>
                                        <td>' . $row['sexoDenunciado'] . '</td>
                                        <td>' . $row['edadDenunciado'] . '</td>
                                        <td>' . $row['servidorPublicoDenunciado'] . '</td>
                                        <td>' . $row['especificarDenunciado'] . '</td>
                                        <td>' . $row['relacionDenunciado'] . '</td>
                                        <td>' . $row['lugarDenuncia'] . '</td>
                                        <td>' . $row['fechaDenuncia'] . '</td>
                                        <td>' . $row['horaDenuncia'] . '</td>
                                        <td>' . $row['narracionDenuncia'] . '</td>
                                        <td>' . $row['nombreTestigo'] . '</td>
                                        <td>' . $row['domicilioTestigo'] . '</td>
                                        <td>' . $row['telefonoTestigo'] . '</td>
                                        <td>' . $row['correoTestigo'] . '</td>
                                        <td>' . $row['relacionTestigo'] . '</td>
                                        <td>' . $row['trabajaTestigo'] . '</td>
                                        <td>' . $row['entidadTestigo'] . '</td>
                                        <td>' . $row['cargoTestigo'] . '</td>
                                        <td>' . $row['statusDenuncia'] . '</td>
                                        <td class="d-flex justify-content-between">
                                            <i class="far fa-edit" onclick="prepararParaEditar(' . "
                                                '" . $row['idDenuncia'] . "',
                                                '" . $row['tipoDenuncia'] . "',
                                                '" . $row['numExpediente'] . "',
                                                '" . date("Y-m-d", strtotime($row['fechaPresentacion'])) . "',
                                                '" . base64_encode($row['imagenDenuncia']) . "',
                                                '" . base64_encode($row['pdfDenuncia']) . "',
                                                '" . $row['anonimatoDenunciante'] . "',
                                                '" . $row['nombreDenunciante'] . "',
                                                '" . $row['domicilioDenunciante'] . "',
                                                '" . $row['telefonoDenunciante'] . "',
                                                '" . $row['correoDenunciante'] . "',
                                                '" . $row['sexoDenunciante'] . "',
                                                '" . $row['edadDenunciante'] . "',
                                                '" . $row['servidorPublicoDenunciante'] . "',
                                                '" . $row['puestoDenunciante'] . "',
                                                '" . $row['especificarDenunciante'] . "',
                                                '" . $row['gradoEstudiosDenunciante'] . "',
                                                '" . $row['discapacidadDenunciante'] . "',
                                                '" . $row['nombreDenunciado'] . "',
                                                '" . $row['entidadDenunciado'] . "',
                                                '" . $row['telefonoDenunciado'] . "',
                                                '" . $row['correoDenunciado'] . "',
                                                '" . $row['sexoDenunciado'] . "',
                                                '" . $row['edadDenunciado'] . "',
                                                '" . $row['servidorPublicoDenunciado'] . "',
                                                '" . $row['especificarDenunciado'] . "',
                                                '" . $row['relacionDenunciado'] . "',
                                                '" . $row['lugarDenuncia'] . "',
                                                '" . $row['fechaDenuncia'] . "',
                                                '" . $row['horaDenuncia'] . "',
                                                '" . preg_replace("/[\r\n|\n|\r]+/", " ", $row['narracionDenuncia']) . "',
                                                '" . $row['nombreTestigo'] . "',
                                                '" . $row['domicilioTestigo'] . "',
                                                '" . $row['telefonoTestigo'] . "',
                                                '" . $row['correoTestigo'] . "',
                                                '" . $row['relacionTestigo'] . "',
                                                '" . $row['trabajaTestigo'] . "',
                                                '" . $row['entidadTestigo'] . "',
                                                '" . $row['cargoTestigo'] . "',
                                                '" . $row['statusDenuncia'] . "'
                                            " . ');"></i>
                                            <i class="far fa-eye" onclick="prepararParaVizualizar(' . "
                                                '" . $row['tipoDenuncia'] . "',
                                                '" . $row['numExpediente'] . "',
                                                '" . date("Y-m-d", strtotime($row['fechaPresentacion'])) . "',
                                                '" . base64_encode($row['imagenDenuncia']) . "',
                                                '" . $row['anonimatoDenunciante'] . "',
                                                '" . $row['nombreDenunciante'] . "',
                                                '" . $row['domicilioDenunciante'] . "',
                                                '" . $row['telefonoDenunciante'] . "',
                                                '" . $row['correoDenunciante'] . "',
                                                '" . $row['sexoDenunciante'] . "',
                                                '" . $row['edadDenunciante'] . "',
                                                '" . $row['servidorPublicoDenunciante'] . "',
                                                '" . $row['puestoDenunciante'] . "',
                                                '" . $row['especificarDenunciante'] . "',
                                                '" . $row['gradoEstudiosDenunciante'] . "',
                                                '" . $row['discapacidadDenunciante'] . "',
                                                '" . $row['nombreDenunciado'] . "',
                                                '" . $row['entidadDenunciado'] . "',
                                                '" . $row['telefonoDenunciado'] . "',
                                                '" . $row['correoDenunciado'] . "',
                                                '" . $row['sexoDenunciado'] . "',
                                                '" . $row['edadDenunciado'] . "',
                                                '" . $row['servidorPublicoDenunciado'] . "',
                                                '" . $row['especificarDenunciado'] . "',
                                                '" . $row['relacionDenunciado'] . "',
                                                '" . $row['lugarDenuncia'] . "',
                                                '" . $row['fechaDenuncia'] . "',
                                                '" . $row['horaDenuncia'] . "',
                                                '" . preg_replace("/[\r\n|\n|\r]+/", " ", $row['narracionDenuncia']) . "',
                                                '" . $row['nombreTestigo'] . "',
                                                '" . $row['domicilioTestigo'] . "',
                                                '" . $row['telefonoTestigo'] . "',
                                                '" . $row['correoTestigo'] . "',
                                                '" . $row['relacionTestigo'] . "',
                                                '" . $row['trabajaTestigo'] . "',
                                                '" . $row['entidadTestigo'] . "',
                                                '" . $row['cargoTestigo'] . "',
                                                '" . $row['statusDenuncia'] . "'
                                            " . ');"></i></button>
                                            <i class="far fa-check-square" onclick="prepararParaConcluir(' . "
                                                '" . $row['idDenuncia'] . "',
                                                '" . $row['numExpediente'] . "'
                                            " . ')"></i>';
                    if ($row['imagenDenuncia'] != "" || $row['nombreDenunciante'] != "") {
                        echo '              <i class="far fa-plus-square" onclick="prepararParaGenerarAcuse(' . "
                                                    '" . $row['tipoDenuncia'] . "',
                                                    '" . $row['numExpediente'] . "',
                                                    '" . date("Y-m-d", strtotime($row['fechaPresentacion'])) . "',
                                                    '" . date("H:i", strtotime($row['fechaPresentacion'])) . "',
                                                    '" . base64_encode($row['imagenDenuncia']) . "',
                                                    '" . $row['anonimatoDenunciante'] . "',
                                                    '" . $row['nombreDenunciante'] . "',
                                                    '" . $row['domicilioDenunciante'] . "',
                                                    '" . $row['telefonoDenunciante'] . "',
                                                    '" . $row['correoDenunciante'] . "',
                                                    '" . $row['sexoDenunciante'] . "',
                                                    '" . $row['edadDenunciante'] . "',
                                                    '" . $row['servidorPublicoDenunciante'] . "',
                                                    '" . $row['puestoDenunciante'] . "',
                                                    '" . $row['especificarDenunciante'] . "',
                                                    '" . $row['gradoEstudiosDenunciante'] . "',
                                                    '" . $row['discapacidadDenunciante'] . "',
                                                    '" . $row['nombreDenunciado'] . "',
                                                    '" . $row['entidadDenunciado'] . "',
                                                    '" . $row['telefonoDenunciado'] . "',
                                                    '" . $row['correoDenunciado'] . "',
                                                    '" . $row['sexoDenunciado'] . "',
                                                    '" . $row['edadDenunciado'] . "',
                                                    '" . $row['servidorPublicoDenunciado'] . "',
                                                    '" . $row['especificarDenunciado'] . "',
                                                    '" . $row['relacionDenunciado'] . "',
                                                    '" . $row['lugarDenuncia'] . "',
                                                    '" . $row['fechaDenuncia'] . "',
                                                    '" . $row['horaDenuncia'] . "',
                                                    '" . preg_replace("/[\r\n|\n|\r]+/", " ", $row['narracionDenuncia']) . "',
                                                    '" . $row['nombreTestigo'] . "',
                                                    '" . $row['domicilioTestigo'] . "',
                                                    '" . $row['telefonoTestigo'] . "',
                                                    '" . $row['correoTestigo'] . "',
                                                    '" . $row['relacionTestigo'] . "',
                                                    '" . $row['trabajaTestigo'] . "',
                                                    '" . $row['entidadTestigo'] . "',
                                                    '" . $row['cargoTestigo'] . "'
                                                " . ');"></i>';
                    } else {
                        echo '              <i class="far fa-minus-square text-white"></i>';
                    }
                    echo '              </td>
                                    </tr>';
                }
                echo '          </tbody>
                            </table>
                        </div>
                    </div>
                </div>';
            }
            if (count($denunciasConcluidas) != 0) {
                echo '
                <span class="py-3 text-light">.</span>
                <div class="col-12">
                    <div class="card bg-white border border-primary border-top-0 border-bottom-0 border-right-0 shadow-sm bg-white rounded">
                        <div class="card-body">
                            <h6 class="card-title text-primary font-weight-bold">CONCLUIDAS</h6>
                            <table id="tablaConcluidas" class="table table-sm table-hover" style="width: 100%;">
                                <thead class="text-white" style="background: linear-gradient(to right, #243B55,#141E30);">
                                    <tr>
                                        <th scope="col">idDenuncia</th>
                                        <th scope="col">tipoDenuncia</th>
                                        <th scope="col" class="text-center"># Expediente</th>
                                        <th scope="col" class="text-center">Fecha de presentación</th>
                                        <th scope="col">anonimatoDenunciante</th>
                                        <th scope="col">Denunciante</th>
                                        <th scope="col">domicilioDenunciante</th>
                                        <th scope="col">telefonoDenunciante</th>
                                        <th scope="col">correoDenunciante</th>
                                        <th scope="col">sexoDenunciante</th>
                                        <th scope="col">edadDenunciante</th>
                                        <th scope="col">servidorPublicoDenunciante</th>
                                        <th scope="col">puestoDenunciante</th>
                                        <th scope="col">especificarDenunciante</th>
                                        <th scope="col">gradoEstudiosDenunciante</th>
                                        <th scope="col">discapacidadDenunciante</th>
                                        <th scope="col">Denunciado</th>
                                        <th scope="col">entidadDenunciado</th>
                                        <th scope="col">telefonoDenunciado</th>
                                        <th scope="col">correoDenunciado</th>
                                        <th scope="col">sexoDenunciado</th>
                                        <th scope="col">edadDenunciado</th>
                                        <th scope="col">servidorPublicoDenunciado</th>
                                        <th scope="col">especificarDenunciado</th>
                                        <th scope="col">relacionDenunciado</th>
                                        <th scope="col">lugarDenuncia</th>
                                        <th scope="col">fechaDenuncia</th>
                                        <th scope="col">horaDenuncia</th>
                                        <th scope="col">narracionDenuncia</th>
                                        <th scope="col">Testigo</th>
                                        <th scope="col">domicilioTestigo</th>
                                        <th scope="col">telefonoTestigo</th>
                                        <th scope="col">correoTestigo</th>
                                        <th scope="col">relacionTestigo</th>
                                        <th scope="col">trabajaTestigo</th>
                                        <th scope="col">entidadTestigo</th>
                                        <th scope="col">cargoTestigo</th>
                                        <th scope="col">statusDenuncia</th>
                                        <th scope="col" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>';
                foreach ($denunciasConcluidas as $row) {
                    echo '                  <tr style="font-size:small;">
                                        <td>' . $row['idDenuncia'] . '</td>
                                        <td>' . $row['tipoDenuncia'] . '</td>
                                        <th scope="row" class="text-center">' . $row['numExpediente'] . '</th>
                                        <td class="text-center">' . date("d-m-Y", strtotime($row['fechaPresentacion'])) . '</td>
                                        <td>' . $row['anonimatoDenunciante'] . '</td>';
                    if ($row['nombreDenunciante'] != "") {
                        echo '                  <td>' . $row['nombreDenunciante'] . '</td>';
                    } else {
                        if (base64_encode($row['imagenDenuncia']) != "") {
                            echo '              <td class="text-success" style="font-size:x-small;"> contiene imagen </td>';
                        } else {
                            echo '              <td class="text-success" style="font-size:x-small;"> denunciante desconocido </td>';
                        }
                    }
                    echo '                      <td>' . $row['domicilioDenunciante'] . '</td>
                                        <td>' . $row['telefonoDenunciante'] . '</td>
                                        <td>' . $row['correoDenunciante'] . '</td>
                                        <td>' . $row['sexoDenunciante'] . '</td>
                                        <td>' . $row['edadDenunciante'] . '</td>
                                        <td>' . $row['servidorPublicoDenunciante'] . '</td>
                                        <td>' . $row['puestoDenunciante'] . '</td>
                                        <td>' . $row['especificarDenunciante'] . '</td>
                                        <td>' . $row['gradoEstudiosDenunciante'] . '</td>
                                        <td>' . $row['discapacidadDenunciante'] . '</td>';
                    if ($row['nombreDenunciado'] != "") {
                        echo '                  <td>' . $row['nombreDenunciado'] . '</td>';
                    } else {
                        if (base64_encode($row['imagenDenuncia']) != "") {
                            echo '              <td class="text-success" style="font-size:x-small;"> contiene imagen </td>';
                        } else {
                            echo '              <td class="text-success" style="font-size:x-small;"> - - - - - - - </td>';
                        }
                    }
                    echo '                      <td>' . $row['entidadDenunciado'] . '</td>
                                        <td>' . $row['telefonoDenunciado'] . '</td>
                                        <td>' . $row['correoDenunciado'] . '</td>
                                        <td>' . $row['sexoDenunciado'] . '</td>
                                        <td>' . $row['edadDenunciado'] . '</td>
                                        <td>' . $row['servidorPublicoDenunciado'] . '</td>
                                        <td>' . $row['especificarDenunciado'] . '</td>
                                        <td>' . $row['relacionDenunciado'] . '</td>
                                        <td>' . $row['lugarDenuncia'] . '</td>
                                        <td>' . $row['fechaDenuncia'] . '</td>
                                        <td>' . $row['horaDenuncia'] . '</td>
                                        <td>' . $row['narracionDenuncia'] . '</td>
                                        <td>' . $row['nombreTestigo'] . '</td>
                                        <td>' . $row['domicilioTestigo'] . '</td>
                                        <td>' . $row['telefonoTestigo'] . '</td>
                                        <td>' . $row['correoTestigo'] . '</td>
                                        <td>' . $row['relacionTestigo'] . '</td>
                                        <td>' . $row['trabajaTestigo'] . '</td>
                                        <td>' . $row['entidadTestigo'] . '</td>
                                        <td>' . $row['cargoTestigo'] . '</td>
                                        <td>' . $row['statusDenuncia'] . '</td>
                                        <td class="d-flex justify-content-around">
                                            <i class="far fa-eye" onclick="prepararParaVizualizar(' . "
                                                '" . $row['tipoDenuncia'] . "',
                                                '" . $row['numExpediente'] . "',
                                                '" . date("Y-m-d", strtotime($row['fechaPresentacion'])) . "',
                                                '" . base64_encode($row['imagenDenuncia']) . "',
                                                '" . $row['anonimatoDenunciante'] . "',
                                                '" . $row['nombreDenunciante'] . "',
                                                '" . $row['domicilioDenunciante'] . "',
                                                '" . $row['telefonoDenunciante'] . "',
                                                '" . $row['correoDenunciante'] . "',
                                                '" . $row['sexoDenunciante'] . "',
                                                '" . $row['edadDenunciante'] . "',
                                                '" . $row['servidorPublicoDenunciante'] . "',
                                                '" . $row['puestoDenunciante'] . "',
                                                '" . $row['especificarDenunciante'] . "',
                                                '" . $row['gradoEstudiosDenunciante'] . "',
                                                '" . $row['discapacidadDenunciante'] . "',
                                                '" . $row['nombreDenunciado'] . "',
                                                '" . $row['entidadDenunciado'] . "',
                                                '" . $row['telefonoDenunciado'] . "',
                                                '" . $row['correoDenunciado'] . "',
                                                '" . $row['sexoDenunciado'] . "',
                                                '" . $row['edadDenunciado'] . "',
                                                '" . $row['servidorPublicoDenunciado'] . "',
                                                '" . $row['especificarDenunciado'] . "',
                                                '" . $row['relacionDenunciado'] . "',
                                                '" . $row['lugarDenuncia'] . "',
                                                '" . $row['fechaDenuncia'] . "',
                                                '" . $row['horaDenuncia'] . "',
                                                '" . preg_replace("/[\r\n|\n|\r]+/", " ", $row['narracionDenuncia']) . "',
                                                '" . $row['nombreTestigo'] . "',
                                                '" . $row['domicilioTestigo'] . "',
                                                '" . $row['telefonoTestigo'] . "',
                                                '" . $row['correoTestigo'] . "',
                                                '" . $row['relacionTestigo'] . "',
                                                '" . $row['trabajaTestigo'] . "',
                                                '" . $row['entidadTestigo'] . "',
                                                '" . $row['cargoTestigo'] . "',
                                                '" . $row['statusDenuncia'] . "'
                                            " . ');"></i>
                                        </td>
                                    </tr>';
                }
                echo '              </tbody>
                            </table>
                        </div>
                    </div>
                </div>';
            }
            echo '<span class="py-3 text-light">.</span></div>';
        }
        break;
}
