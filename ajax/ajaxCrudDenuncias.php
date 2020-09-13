<?php
require_once "../modelos/modeloCrudDenuncias.php";

$accion = (isset($_GET['accion'])) ? $_GET['accion'] : 'leer';

switch ($accion) {
    case 'guardarInfo':
        $anioActual = date("Y");
        $ultimoNumeroExpediente = CrudDenuncias::obtenerUltimoNumeroExpediente($anioActual);
        if (count($ultimoNumeroExpediente) != 0) {
            $ultimoExpediente = explode("-", $ultimoNumeroExpediente[0][0])[0];
            $nuevoExpediente = intval($ultimoExpediente) + 1;
            if ($nuevoExpediente <= 999) {
                if (strlen($nuevoExpediente) == 1) {
                    $cadNuevoExpediente = "00" . strval($nuevoExpediente) . "-" . $anioActual;
                } elseif (strlen($nuevoExpediente) == 2) {
                    $cadNuevoExpediente = "0" . strval($nuevoExpediente) . "-" . $anioActual;
                } else {
                    $cadNuevoExpediente = strval($nuevoExpediente) . "-" . $anioActual;
                }
            } else {
                echo "error|Imposible guardar una nueva denuncia este año. EL PROTOCOLO DE ATENCIÓN A DENUNCIAS POR LOS INCUMPLIMIENTOS DEL CÓDIGO DE ÉTICA DE LA ADMINISTRACIÓN PÚBLICA DEL ESTADO DE HIDALGO Y CÓDIGO DE CONDUCTA DE OFICIALÍA MAYOR, ASI COMO AL PROCEDIMIENTO PARA LA PRESENTACIÓN DE DENUNCIAS ANTE EL COMITÉ DE ÉTICA Y PREVENCIÓN DE CONFLICTOS DE INTERÉS (CEPCI) DE OFICIALIA MAYOR, punto 6, paso 2 determina un formato específico para el número de expediente, de guardar una nueva denuncia el expediente 1000-" . $anioActual . " no coincide con el formato solicitado.";
                break;
            }
        } else {
            $cadNuevoExpediente = "001-" . $anioActual;
        }
        CrudDenuncias::guardarInfo($_POST['txtStatusFormulario'], $_POST['txtTipoDenuncia'], $cadNuevoExpediente, $_POST['txtFechaPresentacion'], $_POST['txtAnonimatoDenunciante'], $_POST['txtNombreDenunciante'], $_POST['txtDomicilioDenunciante'], $_POST['txtTelefonoDenunciante'], $_POST['txtCorreoDenunciante'], $_POST['txtSexoDenunciante'], $_POST['txtEdadDenunciante'], $_POST['txtSPDenunciante'], $_POST['txtPuestoDenunciante'], $_POST['txtEspecificarDenunciante'], $_POST['txtGradoEstudiosDenunciante'], $_POST['txtDiscapacidadDenunciante'], $_POST['txtNombreDenunciado'], $_POST['txtEntidadDenunciado'], $_POST['txtTelefonoDenunciado'], $_POST['txtCorreoDenunciado'], $_POST['txtSexoDenunciado'], $_POST['txtEdadDenunciado'], $_POST['txtSPDenunciado'], $_POST['txtEspecificarDenunciado'], $_POST['txtRelacionDenunciado'], $_POST['txtLugarDenuncia'], $_POST['txtFechaDenuncia'], $_POST['txtHoraDenuncia'], $_POST['txtNarracionDenuncia'], $_POST['txtNombreTestigo'], $_POST['txtDomicilioTestigo'], $_POST['txtTelefonoTestigo'], $_POST['txtCorreoTestigo'], $_POST['txtRelacionTestigo'], $_POST['txtTrabajaTestigo'], $_POST['txtEntidadTestigo'], $_POST['txtCargoTestigo']);
        break;

    case 'editarInfo':
        CrudDenuncias::editarInfo($_POST['txtIdDenuncia'], $_POST['txtStatusFormulario'], $_POST['txtTipoDenuncia'], $_POST['txtNumExpediente'], $_POST['txtFechaPresentacion'], $_POST['txtAnonimatoDenunciante'], $_POST['txtNombreDenunciante'], $_POST['txtDomicilioDenunciante'], $_POST['txtTelefonoDenunciante'], $_POST['txtCorreoDenunciante'], $_POST['txtSexoDenunciante'], $_POST['txtEdadDenunciante'], $_POST['txtSPDenunciante'], $_POST['txtPuestoDenunciante'], $_POST['txtEspecificarDenunciante'], $_POST['txtGradoEstudiosDenunciante'], $_POST['txtDiscapacidadDenunciante'], $_POST['txtNombreDenunciado'], $_POST['txtEntidadDenunciado'], $_POST['txtTelefonoDenunciado'], $_POST['txtCorreoDenunciado'], $_POST['txtSexoDenunciado'], $_POST['txtEdadDenunciado'], $_POST['txtSPDenunciado'], $_POST['txtEspecificarDenunciado'], $_POST['txtRelacionDenunciado'], $_POST['txtLugarDenuncia'], $_POST['txtFechaDenuncia'], $_POST['txtHoraDenuncia'], $_POST['txtNarracionDenuncia'], $_POST['txtNombreTestigo'], $_POST['txtDomicilioTestigo'], $_POST['txtTelefonoTestigo'], $_POST['txtCorreoTestigo'], $_POST['txtRelacionTestigo'], $_POST['txtTrabajaTestigo'], $_POST['txtEntidadTestigo'], $_POST['txtCargoTestigo']);
        break;

    default:
        $denunciasInconclusas = CrudDenuncias::obtenerDenuncias("inconclusa");
        $denunciasPendientes = CrudDenuncias::obtenerDenuncias("pendiente");
        $denunciasConcluidas = CrudDenuncias::obtenerDenuncias("concluida");
        echo '
            <div class="row align-items-center justify-content-center mx-5">
                <div class="col-12 p-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Inconclusas</h5>
                            <table id="tablaInconclusas" class="order-column hover nowrap compact" style="width: 100%;">
                                <thead>
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
                                        <td>' . $row['discapacidadDenunciante'] . '</td>
                                        <td>' . $row['nombreDenunciado'] . '</td>
                                        <td>' . $row['entidadDenunciado'] . '</td>
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
                                                '" . $row['fechaPresentacion'] . "',
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
                                            <i class="far fa-eye"></i>
                                        </td>
                                    </tr>';
        }
        echo '                  </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 p-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pendientes</h5>
                            <table id="tablaPendientes" class="order-column hover nowrap compact" style="width: 100%;">
                                <thead>
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
                                        <td>' . $row['discapacidadDenunciante'] . '</td>
                                        <td>' . $row['nombreDenunciado'] . '</td>
                                        <td>' . $row['entidadDenunciado'] . '</td>
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
                                                '" . $row['fechaPresentacion'] . "',
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
                                            <i class="far fa-eye"></i>
                                            <i class="far fa-check-square"></i>
                                        </td>
                                    </tr>';
        }
        echo '                  </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 p-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Concluidas</h5>
                            <table id="tablaConcluidas" class="order-column hover nowrap compact" style="width: 100%;">
                                <thead>
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
                                        <td>' . $row['discapacidadDenunciante'] . '</td>
                                        <td>' . $row['nombreDenunciado'] . '</td>
                                        <td>' . $row['entidadDenunciado'] . '</td>
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
                                            <i class="far fa-eye"></i>
                                        </td>
                                    </tr>';
        }
        echo '                  </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        ';
        break;
}
