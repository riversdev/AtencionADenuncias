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

    default:
        echo "success|Leer denuncias...";
        break;
}
