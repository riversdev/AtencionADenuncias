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
        $SQL = "INSERT INTO denuncias (tipoDenuncia,numExpediente,fechaPresentacion,anonimatoDenunciante,nombreDenunciante,domicilioDenunciante,telefonoDenunciante,correoDenunciante,sexoDenunciante,edadDenunciante,servidorPublicoDenunciante,puestoDenunciante,especificarDenunciante,gradoEstudiosDenunciante,discapacidadDenunciante,nombreDenunciado,entidadDenunciado,telefonoDenunciado,correoDenunciado,sexoDenunciado,edadDenunciado,servidorPublicoDenunciado,especificarDenunciado,relacionDenunciado,lugarDenuncia,fechaDenuncia,horaDenuncia,narracionDenuncia,nombreTestigo,domicilioTestigo,telefonoTestigo,correoTestigo,relacionTestigo,trabajaTestigo,entidadTestigo,cargoTestigo,statusDenuncia) VALUES ('$tipoDenuncia','$numExpediente','$fechaPresentacion','$anonimatoDenunciante','$nombreDenunciante','$domicilioDenunciante','$telefonoDenunciante','$correoDenunciante','$sexoDenunciante','$edadDenunciante','$servidorPublicoDenunciante','$puestoDenunciante','$especificarDenunciante','$gradoEstudiosDenunciante','$discapacidadDenunciante','$nombreDenunciado','$entidadDenunciado','$telefonoDenunciado','$correoDenunciado','$sexoDenunciado','$edadDenunciado','$servidorPublicoDenunciado','$especificarDenunciado','$relacionDenunciado','$lugarDenuncia','$fechaDenuncia','$horaDenuncia','$narracionDenuncia','$nombreTestigo','$domicilioTestigo','$telefonoTestigo','$correoTestigo','$relacionTestigo','$trabajaTestigo','$entidadTestigo','$cargoTestigo','$statusInformacion');";
        $stmt = Conexion::conectar()->prepare($SQL);
        try {
            if ($stmt->execute()) {
                echo "success|Denuncia " . $statusInformacion . " guardada !";
            } else {
                echo "error|Imposible guardar denuncia " . $statusInformacion . " !";
            }
        } catch (Exception $e) {
            echo "error|Sin conexión !";
        }
        $stmt = null;
    }
    public static function guardarImg($tipoDenuncia, $numExpediente, $fechaPresentacion, $imagenDenuncia)
    {
        $SQL = "INSERT INTO denuncias (tipoDenuncia,numExpediente,fechaPresentacion,imagenDenuncia,statusDenuncia) VALUES ('$tipoDenuncia','$numExpediente','$fechaPresentacion','$imagenDenuncia','pendiente');";
        $stmt = Conexion::conectar()->prepare($SQL);
        try {
            if ($stmt->execute()) {
                echo "success|Denuncia pendiente guardada !";
            } else {
                echo "error|Imposible guardar denuncia pendiente !";
            }
        } catch (Exception $e) {
            echo "error|Imagen demasiado grande !";
        }
        $stmt = null;
    }
    public static function editarInfo($idDenuncia, $statusInformacion, $tipoDenuncia, $numExpediente, $fechaPresentacion, $anonimatoDenunciante, $nombreDenunciante, $domicilioDenunciante, $telefonoDenunciante, $correoDenunciante, $sexoDenunciante, $edadDenunciante, $servidorPublicoDenunciante, $puestoDenunciante, $especificarDenunciante, $gradoEstudiosDenunciante, $discapacidadDenunciante, $nombreDenunciado, $entidadDenunciado, $telefonoDenunciado, $correoDenunciado, $sexoDenunciado, $edadDenunciado, $servidorPublicoDenunciado, $especificarDenunciado, $relacionDenunciado, $lugarDenuncia, $fechaDenuncia, $horaDenuncia, $narracionDenuncia, $nombreTestigo, $domicilioTestigo, $telefonoTestigo, $correoTestigo, $relacionTestigo, $trabajaTestigo, $entidadTestigo, $cargoTestigo)
    {
        $SQL = "UPDATE denuncias
                SET tipoDenuncia='$tipoDenuncia',
                    numExpediente='$numExpediente',
                    fechaPresentacion='$fechaPresentacion',
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
            echo "error|Sin conexión !";
        }
        $stmt = null;
    }
    public static function editarImg($idDenuncia, $tipoDenuncia, $numExpediente, $fechaPresentacion, $imagenDenuncia)
    {
        $SQL = "UPDATE denuncias
                SET tipoDenuncia='$tipoDenuncia',
                    numExpediente='$numExpediente',
                    fechaPresentacion='$fechaPresentacion',
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
            echo "error|Imagen demasiado grande !";
        }
        $stmt = null;
    }
    public static function editarImgSinImg($idDenuncia, $tipoDenuncia, $numExpediente, $fechaPresentacion)
    {
        $SQL = "UPDATE denuncias
                SET tipoDenuncia='$tipoDenuncia',
                    numExpediente='$numExpediente',
                    fechaPresentacion='$fechaPresentacion'
                WHERE idDenuncia='$idDenuncia';";
        $stmt = Conexion::conectar()->prepare($SQL);
        try {
            if ($stmt->execute()) {
                echo "success|Denuncia pendiente editada !";
            } else {
                echo "error|Imposible editar denuncia pendiente !";
            }
        } catch (Exception $e) {
            echo "error|Imagen demasiado grande !";
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
            echo "error|Sin conexión !";
        }
        $stmt = null;
    }
}
