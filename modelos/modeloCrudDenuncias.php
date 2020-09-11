<?php
require_once "modeloConexion.php";

class CrudDenuncias
{
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
    }
}
