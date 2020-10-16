<?php
error_reporting(0);

require_once "modeloConexion.php";

class CrudDenuncias
{
    public static function obtenerDenuncias($statusDenuncia)
    {
        $SQL = "SELECT * FROM denuncias WHERE statusDenuncia='$statusDenuncia' ORDER BY fechaPresentacion DESC";
        $stmt = Conexion::conectar()->prepare($SQL);
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        $stmt = null;
        return $resultado;
    }
    public static function obtenerUltimoNumeroExpediente($anioActual)
    {
        $SQL = "SELECT a.numExpediente FROM denuncias AS a WHERE a.numExpediente LIKE '%$anioActual' ORDER BY a.numExpediente DESC LIMIT 1";
        $stmt = Conexion::conectar()->prepare($SQL);
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        $stmt = null;
        return $resultado;
    }
    public static function guardarInfo($statusInformacion, $tipoDenuncia, $numExpediente, $fechaPresentacion, $anonimatoDenunciante, $nombreDenunciante, $domicilioDenunciante, $telefonoDenunciante, $correoDenunciante, $sexoDenunciante, $edadDenunciante, $servidorPublicoDenunciante, $puestoDenunciante, $especificarDenunciante, $gradoEstudiosDenunciante, $discapacidadDenunciante, $nombreDenunciado, $entidadDenunciado, $telefonoDenunciado, $correoDenunciado, $sexoDenunciado, $edadDenunciado, $servidorPublicoDenunciado, $especificarDenunciado, $relacionDenunciado, $lugarDenuncia, $fechaDenuncia, $horaDenuncia, $narracionDenuncia, $nombreTestigo, $domicilioTestigo, $telefonoTestigo, $correoTestigo, $relacionTestigo, $trabajaTestigo, $entidadTestigo, $cargoTestigo)
    {
        $marcaDeTiempo = $fechaPresentacion . " " . date("H:i:s", strtotime(date("H:i:s") . "- 7 hours"));
        $SQL = "INSERT INTO denuncias (tipoDenuncia,numExpediente,fechaPresentacion,anonimatoDenunciante,nombreDenunciante,domicilioDenunciante,telefonoDenunciante,correoDenunciante,sexoDenunciante,edadDenunciante,servidorPublicoDenunciante,puestoDenunciante,especificarDenunciante,gradoEstudiosDenunciante,discapacidadDenunciante,nombreDenunciado,entidadDenunciado,telefonoDenunciado,correoDenunciado,sexoDenunciado,edadDenunciado,servidorPublicoDenunciado,especificarDenunciado,relacionDenunciado,lugarDenuncia,fechaDenuncia,horaDenuncia,narracionDenuncia,nombreTestigo,domicilioTestigo,telefonoTestigo,correoTestigo,relacionTestigo,trabajaTestigo,entidadTestigo,cargoTestigo,statusDenuncia) VALUES ('$tipoDenuncia','$numExpediente','$marcaDeTiempo','$anonimatoDenunciante','$nombreDenunciante','$domicilioDenunciante','$telefonoDenunciante','$correoDenunciante','$sexoDenunciante','$edadDenunciante','$servidorPublicoDenunciante','$puestoDenunciante','$especificarDenunciante','$gradoEstudiosDenunciante','$discapacidadDenunciante','$nombreDenunciado','$entidadDenunciado','$telefonoDenunciado','$correoDenunciado','$sexoDenunciado','$edadDenunciado','$servidorPublicoDenunciado','$especificarDenunciado','$relacionDenunciado','$lugarDenuncia','$fechaDenuncia','$horaDenuncia','$narracionDenuncia','$nombreTestigo','$domicilioTestigo','$telefonoTestigo','$correoTestigo','$relacionTestigo','$trabajaTestigo','$entidadTestigo','$cargoTestigo','$statusInformacion');";
        $stmt = Conexion::conectar()->prepare($SQL);
        try {
            if ($stmt->execute()) {
                echo "success|Denuncia " . $statusInformacion . " guardada !";
            } else {
                echo "error|Imposible guardar denuncia " . $statusInformacion . " !";
            }
        } catch (Exception $e) {
            echo "error|Imposible guardar denuncia !|" . $e;
        }
        $stmt = null;
    }
    public static function guardarImg($tipoDenuncia, $numExpediente, $fechaPresentacion, $imagenDenuncia)
    {
        $marcaDeTiempo = $fechaPresentacion . " " . date("H:i:s", strtotime(date("H:i:s") . "- 7 hours"));
        $SQL = "INSERT INTO denuncias (tipoDenuncia,numExpediente,fechaPresentacion,imagenDenuncia,statusDenuncia) VALUES ('$tipoDenuncia','$numExpediente','$marcaDeTiempo','$imagenDenuncia','pendiente');";
        $stmt = Conexion::conectar()->prepare($SQL);
        try {
            if ($stmt->execute()) {
                echo "success|Denuncia pendiente guardada !";
            } else {
                echo "error|Imposible guardar denuncia pendiente !";
            }
        } catch (Exception $e) {
            echo "error|Imagen demasiado grande !|" . $e;
        }
        $stmt = null;
    }
    public static function guardarPdf($tipoDenuncia, $numExpediente, $fechaPresentacion, $pdfDenuncia)
    {
        $marcaDeTiempo = $fechaPresentacion . " " . date("H:i:s", strtotime(date("H:i:s") . "- 7 hours"));
        $SQL = "INSERT INTO denuncias (tipoDenuncia,numExpediente,fechaPresentacion,pdfDenuncia,statusDenuncia) VALUES ('$tipoDenuncia','$numExpediente','$marcaDeTiempo','$pdfDenuncia','pendiente');";
        $stmt = Conexion::conectar()->prepare($SQL);
        try {
            if ($stmt->execute()) {
                echo "success|Denuncia pendiente guardada !";
            } else {
                echo "error|Imposible guardar denuncia pendiente !";
            }
        } catch (Exception $e) {
            echo "error|Documento demasiado grande !|" . $e;
        }
        $stmt = null;
    }
    public static function editarInfo($idDenuncia, $statusInformacion, $tipoDenuncia, $numExpediente, $fechaPresentacion, $anonimatoDenunciante, $nombreDenunciante, $domicilioDenunciante, $telefonoDenunciante, $correoDenunciante, $sexoDenunciante, $edadDenunciante, $servidorPublicoDenunciante, $puestoDenunciante, $especificarDenunciante, $gradoEstudiosDenunciante, $discapacidadDenunciante, $nombreDenunciado, $entidadDenunciado, $telefonoDenunciado, $correoDenunciado, $sexoDenunciado, $edadDenunciado, $servidorPublicoDenunciado, $especificarDenunciado, $relacionDenunciado, $lugarDenuncia, $fechaDenuncia, $horaDenuncia, $narracionDenuncia, $nombreTestigo, $domicilioTestigo, $telefonoTestigo, $correoTestigo, $relacionTestigo, $trabajaTestigo, $entidadTestigo, $cargoTestigo)
    {
        $SQL = "UPDATE denuncias
                SET tipoDenuncia='$tipoDenuncia',
                    numExpediente='$numExpediente',
                    anonimatoDenunciante='$anonimatoDenunciante',
                    nombreDenunciante='$nombreDenunciante',
                    domicilioDenunciante='$domicilioDenunciante',
                    telefonoDenunciante='$telefonoDenunciante',
                    correoDenunciante='$correoDenunciante',
                    sexoDenunciante='$sexoDenunciante',
                    edadDenunciante='$edadDenunciante',
                    servidorPublicoDenunciante='$servidorPublicoDenunciante',
                    puestoDenunciante='$puestoDenunciante',
                    especificarDenunciante='$especificarDenunciante',
                    gradoEstudiosDenunciante='$gradoEstudiosDenunciante',
                    discapacidadDenunciante='$discapacidadDenunciante',
                    nombreDenunciado='$nombreDenunciado',
                    entidadDenunciado='$entidadDenunciado',
                    telefonoDenunciado='$telefonoDenunciado',
                    correoDenunciado='$correoDenunciado',
                    sexoDenunciado='$sexoDenunciado',
                    edadDenunciado='$edadDenunciado',
                    servidorPublicoDenunciado='$servidorPublicoDenunciado',
                    especificarDenunciado='$especificarDenunciado',
                    relacionDenunciado='$relacionDenunciado',
                    lugarDenuncia='$lugarDenuncia',
                    fechaDenuncia='$fechaDenuncia',
                    horaDenuncia='$horaDenuncia',
                    narracionDenuncia='$narracionDenuncia',
                    nombreTestigo='$nombreTestigo',
                    domicilioTestigo='$domicilioTestigo',
                    telefonoTestigo='$telefonoTestigo',
                    correoTestigo='$correoTestigo',
                    relacionTestigo='$relacionTestigo',
                    trabajaTestigo='$trabajaTestigo',
                    entidadTestigo='$entidadTestigo',
                    cargoTestigo='$cargoTestigo',
                    statusDenuncia='$statusInformacion'
                WHERE idDenuncia='$idDenuncia';";
        $stmt = Conexion::conectar()->prepare($SQL);
        try {
            if ($stmt->execute()) {
                echo "success|Denuncia " . $statusInformacion . " editada !";
            } else {
                echo "error|Imposible editar denuncia " . $statusInformacion . " !";
            }
        } catch (Exception $e) {
            echo "error|Imposible editar denuncia !|" . $e;
        }
        $stmt = null;
    }
    public static function editarImg($idDenuncia, $tipoDenuncia, $numExpediente, $fechaPresentacion, $imagenDenuncia)
    {
        $SQL = "UPDATE denuncias
                SET tipoDenuncia='$tipoDenuncia',
                    numExpediente='$numExpediente',
                    imagenDenuncia='$imagenDenuncia'
                WHERE idDenuncia='$idDenuncia';";
        $stmt = Conexion::conectar()->prepare($SQL);
        try {
            if ($stmt->execute()) {
                echo "success|Denuncia pendiente editada !";
            } else {
                echo "error|Imposible editar denuncia pendiente !";
            }
        } catch (Exception $e) {
            echo "error|Imagen demasiado grande !|" . $e;
        }
        $stmt = null;
    }
    public static function editarPdf($idDenuncia, $tipoDenuncia, $numExpediente, $pdfDenuncia)
    {
        $SQL = "UPDATE denuncias
                SET tipoDenuncia='$tipoDenuncia',
                    numExpediente='$numExpediente',
                    pdfDenuncia='$pdfDenuncia'
                WHERE idDenuncia='$idDenuncia';";
        $stmt = Conexion::conectar()->prepare($SQL);
        try {
            if ($stmt->execute()) {
                echo "success|Denuncia pendiente editada !";
            } else {
                echo "error|Imposible editar denuncia pendiente !";
            }
        } catch (Exception $e) {
            echo "error|Documento demasiado grande !|" . $e;
        }
        $stmt = null;
    }
    public static function editarImgSinImg($idDenuncia, $tipoDenuncia, $numExpediente, $fechaPresentacion)
    {
        $SQL = "UPDATE denuncias
                SET tipoDenuncia='$tipoDenuncia',
                    numExpediente='$numExpediente'
                WHERE idDenuncia='$idDenuncia';";
        $stmt = Conexion::conectar()->prepare($SQL);
        try {
            if ($stmt->execute()) {
                echo "success|Denuncia pendiente editada !";
            } else {
                echo "error|Imposible editar denuncia pendiente !";
            }
        } catch (Exception $e) {
            echo "error|Imposible editar denuncia !|" . $e;
        }
        $stmt = null;
    }
    public static function editarPdfSinPdf($idDenuncia, $tipoDenuncia, $numExpediente)
    {
        $SQL = "UPDATE denuncias
                SET tipoDenuncia='$tipoDenuncia',
                    numExpediente='$numExpediente'
                WHERE idDenuncia='$idDenuncia';";
        $stmt = Conexion::conectar()->prepare($SQL);
        try {
            if ($stmt->execute()) {
                echo "success|Denuncia pendiente editada !";
            } else {
                echo "error|Imposible editar denuncia pendiente !";
            }
        } catch (Exception $e) {
            echo "error|Documento demasiado grande !|" . $e;
        }
        $stmt = null;
    }
    public static function concluirDenuncia($idDenuncia)
    {
        $SQL = "UPDATE denuncias
                SET statusDenuncia='concluida'
                WHERE idDenuncia='$idDenuncia';";
        $stmt = Conexion::conectar()->prepare($SQL);
        try {
            if ($stmt->execute()) {
                echo "success|Denuncia concluida !";
            } else {
                echo "error|Imposible concluir denuncia !";
            }
        } catch (Exception $e) {
            echo "error|Imposible concluir denuncia !|" . $e;
        }
        $stmt = null;
    }
    public static function verificarDenunciasInconclusas($fechaVerificar, $fechaActual)
    {
        $SQL = "SELECT * FROM denuncias WHERE statusDenuncia='inconclusa' AND fechaPresentacion BETWEEN '$fechaVerificar' AND '$fechaActual';";
        $stmt = Conexion::conectar()->prepare($SQL);
        try {
            $stmt->execute();
            if (count($stmt->fetchAll()) != 0) {
                echo "warning|Tiene denuncias por completar !";
            } else {
                echo "success|No tiene denuncias por completar !";
            }
        } catch (Exception $e) {
            echo "error|Imposible leer denuncias inconclusas !|" . $e;
        }
        $stmt = null;
    }
    public static function concluirDenunciasSinSeguimiento($fechaVerificar)
    {
        $SQL = "UPDATE denuncias
                SET statusDenuncia='concluida',
                    tipoDenuncia=CONCAT(tipoDenuncia,'-¡Inconclusa!')
                WHERE fechaPresentacion<='$fechaVerificar';";
        $stmt = Conexion::conectar()->prepare($SQL);
        try {
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
        $stmt = null;
    }
    public static function buscarSinSeguimiento($fechaVerificar)
    {
        $SQL = "SELECT * FROM denuncias WHERE fechaPresentacion<='$fechaVerificar' AND statusDenuncia='inconclusa';";
        $stmt = Conexion::conectar()->prepare($SQL);
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        $stmt = null;
        return $resultado;
    }
    public static function guardarActaPDF($idDenuncia, $pdfActaDenuncia)
    {
        $SQL = "UPDATE denuncias
                SET pdfActaDenuncia='$pdfActaDenuncia'
                WHERE idDenuncia='$idDenuncia';";
        $stmt = Conexion::conectar()->prepare($SQL);
        try {
            if ($stmt->execute()) {
                return 1;
            } else {
                return 0;
            }
        } catch (Exception $e) {
            return "error|Documento demasiado grande !|" . $e;
        }
        $stmt = null;
    }
}
