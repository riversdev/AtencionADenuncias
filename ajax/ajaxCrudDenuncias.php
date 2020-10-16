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
                CrudDenuncias::guardarImg($_POST['txtImagenPresunto'], $nuevoExpediente, $_POST['txtImagenFechaPresentacionV'], $imagenBinaria);
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
                CrudDenuncias::guardarPdf($_POST['txtPresuntoPDF'], $nuevoExpediente, $_POST['txtFechaPresentacionPDFV'], $documentoBinario);
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

    case 'guardarActa':
        if ($_FILES['txtActaDenunciaPDF']['error'] === 4) {
            echo "error|Elija un documento";
        } elseif ($_FILES['txtActaDenunciaPDF']['error'] === 1) {
            die("error|El documento sobrepasa el limite de tamaño (2MB)");
        } elseif ($_FILES['txtActaDenunciaPDF']['error'] === 0) {
            $documentoBinario = addslashes(file_get_contents($_FILES['txtActaDenunciaPDF']['tmp_name']));
            $nombreArchivo = $_FILES['txtActaDenunciaPDF']['name'];
            $extensiones = array('pdf', 'doc', 'docx');
            $extension = explode('.', $nombreArchivo);
            $extension = end($extension);
            $extension = strtolower($extension);
            if (!in_array($extension, $extensiones)) {
                die('error|Sólo elija documentos con extensiones: ' . implode(', ', $extensiones));
            } else {
                $resultado = CrudDenuncias::guardarActaPDF($_POST['txtIdDenunciaActa'], $documentoBinario);
                if ($resultado == 1) {
                    CrudDenuncias::concluirDenuncia($_POST['txtIdDenunciaActa']);
                } else if ($resultado == 0) {
                    echo "error|Imposible guardar acta !";
                } else {
                    echo $resultado;
                }
            }
        } else {
            die("error|Verifique sus datos");
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
                    <div class="card bg-white shadow" style="border: 0;">
                        <div class="card-body rounded" style="border-left: 5px solid #6fb430;border-top:0;border-right:0;border-bottom: 0;">
                            <h6 class="card-title text-primary font-weight-bold">INCONCLUSAS</h6>
                            <table id="tablaInconclusas" class="table table-sm table-hover" style="width: 100%;">
                                <thead class="text-dark" style="background-color:#F7F7F9;">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Tipo de denuncia</th>
                                        <th scope="col" class="text-center"># Expediente</th>
                                        <th scope="col" class="text-center">Fecha de presentación</th>
                                        <th scope="col">¿El denunciante desea el anonimato?</th>
                                        <th scope="col">Denunciante</th>
                                        <th scope="col">Domicilio del denunciante</th>
                                        <th scope="col">Teléfono del denunciante</th>
                                        <th scope="col">Correo del denunciante</th>
                                        <th scope="col">Sexo del denunciante</th>
                                        <th scope="col">Edad del denunciante</th>
                                        <th scope="col">¿El denunciante es un servidor público?</th>
                                        <th scope="col">Puesto del denunciante</th>
                                        <th scope="col">Especificar</th>
                                        <th scope="col">Grado de estudios del denunciante</th>
                                        <th scope="col">Discapacidad del denunciante</th>
                                        <th scope="col">Denunciado</th>
                                        <th scope="col">Entidad del denunciado</th>
                                        <th scope="col">Teléfono del denunciado</th>
                                        <th scope="col">Correo del denunciado</th>
                                        <th scope="col">Sexo del denunciado</th>
                                        <th scope="col">Edad del denunciado</th>
                                        <th scope="col">¿El denunciado es un servidor público?</th>
                                        <th scope="col">Especificar</th>
                                        <th scope="col">Relación con el denunciante</th>
                                        <th scope="col">Lugar de la denuncia</th>
                                        <th scope="col">Fecha de la denuncia</th>
                                        <th scope="col">Hora de la denuncia</th>
                                        <th scope="col">Breve narración de la denuncia</th>
                                        <th scope="col">Nombre del testigo</th>
                                        <th scope="col">Domicilio del testigo</th>
                                        <th scope="col">Teléfono del testigo</th>
                                        <th scope="col">Correo electrónico del testigo</th>
                                        <th scope="col">Relación con el denunciante</th>
                                        <th scope="col">¿Trabaja en la Administración Pública Estatal?</th>
                                        <th scope="col">Entidad o dependencia</th>
                                        <th scope="col">Cargo</th>
                                        <th scope="col">Estatus de la denuncia</th>
                                        <th scope="col" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>';
                foreach ($denunciasInconclusas as $row) {
                    echo '          <tr style="font-size:small;">
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
                        echo '          <td>' . $row['nombreDenunciado'] . '</td>';
                    } else {
                        echo '          <td class="text-success" style="font-size:x-small;"> - - - - - - - </td>';
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
                                            <i class="far fa-lg fa-edit text-warning adminElement" data-toggle="tooltip" data-placement="left" title="Editar" onclick="prepararParaEditar(' . "
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
                                                " . ');">
                                            </i>
                                            <i class="far fa-lg fa-eye text-info" data-toggle="tooltip" data-placement="left" title="Vizualizar" onclick="prepararParaVizualizar(' . "
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
                                                " . ');">
                                            </i>
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
                    <div class="card bg-white shadow" style="border: 0;">
                        <div class="card-body rounded" style="border-left: 5px solid #6fb430;border-top:0;border-right:0;border-bottom: 0;">
                            <h6 class="card-title text-primary font-weight-bold">PENDIENTES</h6>
                            <table id="tablaPendientes" class="table table-sm table-hover" style="width: 100%;">
                                <thead class="text-dark" style="background-color:#F7F7F9;">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Tipo de denuncia</th>
                                        <th scope="col" class="text-center"># Expediente</th>
                                        <th scope="col" class="text-center">Fecha de presentación</th>
                                        <th scope="col">¿El denunciante desea el anonimato?</th>
                                        <th scope="col">Denunciante</th>
                                        <th scope="col">Domicilio del denunciante</th>
                                        <th scope="col">Teléfono del denunciante</th>
                                        <th scope="col">Correo del denunciante</th>
                                        <th scope="col">Sexo del denunciante</th>
                                        <th scope="col">Edad del denunciante</th>
                                        <th scope="col">¿El denunciante es un servidor público?</th>
                                        <th scope="col">Puesto del denunciante</th>
                                        <th scope="col">Especificar</th>
                                        <th scope="col">Grado de estudios del denunciante</th>
                                        <th scope="col">Discapacidad del denunciante</th>
                                        <th scope="col">Denunciado</th>
                                        <th scope="col">Entidad del denunciado</th>
                                        <th scope="col">Teléfono del denunciado</th>
                                        <th scope="col">Correo del denunciado</th>
                                        <th scope="col">Sexo del denunciado</th>
                                        <th scope="col">Edad del denunciado</th>
                                        <th scope="col">¿El denunciado es un servidor público?</th>
                                        <th scope="col">Especificar</th>
                                        <th scope="col">Relación con el denunciante</th>
                                        <th scope="col">Lugar de la denuncia</th>
                                        <th scope="col">Fecha de la denuncia</th>
                                        <th scope="col">Hora de la denuncia</th>
                                        <th scope="col">Breve narración de la denuncia</th>
                                        <th scope="col">Nombre del testigo</th>
                                        <th scope="col">Domicilio del testigo</th>
                                        <th scope="col">Teléfono del testigo</th>
                                        <th scope="col">Correo electrónico del testigo</th>
                                        <th scope="col">Relación con el denunciante</th>
                                        <th scope="col">¿Trabaja en la Administración Pública Estatal?</th>
                                        <th scope="col">Entidad o dependencia</th>
                                        <th scope="col">Cargo</th>
                                        <th scope="col">Estatus de la denuncia</th>
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
                        echo '          <td>' . $row['nombreDenunciante'] . '</td>';
                    } elseif (base64_encode($row['imagenDenuncia']) != "") {
                        echo '          <td class="text-success" style="font-size:x-small;"> contiene imagen </td>';
                    } elseif (base64_encode($row['pdfDenuncia']) != "") {
                        echo '          <td class="text-success" style="font-size:x-small;"> contiene pdf </td>';
                    } else {
                        echo '          <td class="text-success" style="font-size:x-small;"> denunciante desconocido </td>';
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
                        echo '          <td>' . $row['nombreDenunciado'] . '</td>';
                    } elseif (base64_encode($row['imagenDenuncia']) != "") {
                        echo '          <td class="text-success" style="font-size:x-small;"> contiene imagen </td>';
                    } elseif (base64_encode($row['pdfDenuncia']) != "") {
                        echo '          <td class="text-success" style="font-size:x-small;"> contiene pdf </td>';
                    } else {
                        echo '          <td class="text-success" style="font-size:x-small;"> denunciado desconocido </td>';
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
                                            <i class="far fa-lg fa-edit text-warning adminElement" data-toggle="tooltip" data-placement="left" title="Editar" onclick="prepararParaEditar(' . "
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
                                                " . ');">
                                            </i>
                                            <i class="far fa-lg fa-eye text-info" data-toggle="tooltip" data-placement="left" title="Vizualizar" onclick="prepararParaVizualizar(' . "
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
                                                " . ');">
                                            </i>
                                            <i class="far fa-lg fa-check-square text-success adminElement" data-toggle="tooltip" data-placement="left" title="Concluir" onclick="prepararParaConcluir(' . "
                                                '" . $row['idDenuncia'] . "',
                                                '" . $row['tipoDenuncia'] . "',
                                                '" . $row['numExpediente'] . "',
                                                '" . date("Y-m-d", strtotime($row['fechaPresentacion'])) . "'
                                                " . ')">
                                            </i>
                                            ';
                    if ($row['imagenDenuncia'] != "" || $row['nombreDenunciante'] != "" || base64_encode($row['pdfDenuncia']) != "") {
                        echo '
                                            <i class="far fa-lg fa-plus-square text-dark" data-toggle="tooltip" data-placement="left" title="Generar acuse" onclick="prepararParaGenerarAcuse(' . "
                                                '" . $row['tipoDenuncia'] . "',
                                                '" . $row['numExpediente'] . "',
                                                '" . date("Y-m-d", strtotime($row['fechaPresentacion'])) . "',
                                                '" . date("H:i", strtotime($row['fechaPresentacion'])) . "',
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
                                                '" . $row['cargoTestigo'] . "'
                                                " . ');">
                                            </i>
                        ';
                    } else {
                        echo '              <i class="far fa-lg fa-minus-square text-white"></i>';
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
                    <div class="card bg-white shadow" style="border: 0;">
                        <div class="card-body rounded" style="border-left: 5px solid #6fb430;border-top:0;border-right:0;border-bottom: 0;">
                            <h6 class="card-title text-primary font-weight-bold">CONCLUIDAS</h6>
                            <table id="tablaConcluidas" class="table table-sm table-hover" style="width: 100%;">
                                <thead class="text-dark" style="background-color:#F7F7F9;">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Tipo de denuncia</th>
                                        <th scope="col" class="text-center"># Expediente</th>
                                        <th scope="col" class="text-center">Fecha de presentación</th>
                                        <th scope="col">¿El denunciante desea el anonimato?</th>
                                        <th scope="col">Denunciante</th>
                                        <th scope="col">Domicilio del denunciante</th>
                                        <th scope="col">Teléfono del denunciante</th>
                                        <th scope="col">Correo del denunciante</th>
                                        <th scope="col">Sexo del denunciante</th>
                                        <th scope="col">Edad del denunciante</th>
                                        <th scope="col">¿El denunciante es un servidor público?</th>
                                        <th scope="col">Puesto del denunciante</th>
                                        <th scope="col">Especificar</th>
                                        <th scope="col">Grado de estudios del denunciante</th>
                                        <th scope="col">Discapacidad del denunciante</th>
                                        <th scope="col">Denunciado</th>
                                        <th scope="col">Entidad del denunciado</th>
                                        <th scope="col">Teléfono del denunciado</th>
                                        <th scope="col">Correo del denunciado</th>
                                        <th scope="col">Sexo del denunciado</th>
                                        <th scope="col">Edad del denunciado</th>
                                        <th scope="col">¿El denunciado es un servidor público?</th>
                                        <th scope="col">Especificar</th>
                                        <th scope="col">Relación con el denunciante</th>
                                        <th scope="col">Lugar de la denuncia</th>
                                        <th scope="col">Fecha de la denuncia</th>
                                        <th scope="col">Hora de la denuncia</th>
                                        <th scope="col">Breve narración de la denuncia</th>
                                        <th scope="col">Nombre del testigo</th>
                                        <th scope="col">Domicilio del testigo</th>
                                        <th scope="col">Teléfono del testigo</th>
                                        <th scope="col">Correo electrónico del testigo</th>
                                        <th scope="col">Relación con el denunciante</th>
                                        <th scope="col">¿Trabaja en la Administración Pública Estatal?</th>
                                        <th scope="col">Entidad o dependencia</th>
                                        <th scope="col">Cargo</th>
                                        <th scope="col">Estatus de la denuncia</th>
                                        <th scope="col" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>';
                foreach ($denunciasConcluidas as $row) {
                    echo '          <tr style="font-size:small;">
                                        <td>' . $row['idDenuncia'] . '</td>
                                        <td>' . $row['tipoDenuncia'] . '</td>
                                        <th scope="row" class="text-center">' . $row['numExpediente'] . '</th>
                                        <td class="text-center">' . date("d-m-Y", strtotime($row['fechaPresentacion'])) . '</td>
                                        <td>' . $row['anonimatoDenunciante'] . '</td>';
                    if ($row['nombreDenunciante'] != "") {
                        echo '          <td>' . $row['nombreDenunciante'] . '</td>';
                    } elseif (base64_encode($row['imagenDenuncia']) != "") {
                        echo '          <td class="text-success" style="font-size:x-small;"> contiene imagen </td>';
                    } elseif (base64_encode($row['pdfDenuncia']) != "") {
                        echo '          <td class="text-success" style="font-size:x-small;"> contiene pdf </td>';
                    } else {
                        echo '          <td class="text-success" style="font-size:x-small;"> denunciante desconocido </td>';
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
                        echo '          <td>' . $row['nombreDenunciado'] . '</td>';
                    } elseif (base64_encode($row['imagenDenuncia']) != "") {
                        echo '          <td class="text-success" style="font-size:x-small;"> contiene imagen </td>';
                    } elseif (base64_encode($row['pdfDenuncia']) != "") {
                        echo '          <td class="text-success" style="font-size:x-small;"> contiene pdf </td>';
                    } else {
                        echo '          <td class="text-success" style="font-size:x-small;"> denunciado desconocido </td>';
                    }
                    echo '              <td>' . $row['entidadDenunciado'] . '</td>
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
                                            <i class="far fa-lg fa-eye text-info" data-toggle="tooltip" data-placement="left" title="Vizualizar" onclick="prepararParaVizualizar(' . "
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
                                                " . ');">
                                            </i>
                                            <i class="far fa-lg fa-plus-square text-dark" data-toggle="tooltip" data-placement="left" title="Mostrar acta" onclick="prepararParaMostrarActa(' . "
                                                '" . base64_encode($row['pdfActaDenuncia']) . "'
                                                " . ');">
                                            </i>
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
