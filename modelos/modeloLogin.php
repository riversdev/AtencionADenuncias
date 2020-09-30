<?php
session_start();

require_once "modeloConexion.php";

class Login
{
    public static function identificarUsuario($usuario, $contrasenia)
    {
        $SQL = "SELECT idUsuario,contrasenia FROM usuarios WHERE usuario='$usuario';";
        $stmt = Conexion::conectar()->prepare($SQL);
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        if (count($resultado) > 0 && password_verify($contrasenia, $resultado[0]['contrasenia'])) {
            $_SESSION['user_id'] = $resultado[0]['idUsuario'];
            Login::validarAccesos($resultado[0]['idUsuario']);
        } else {
            echo "error|Verifica tus datos!";
        }
        $stmt = null;
    }
    public static function validarPermisos($idUsuario)
    {
        $SQL = "SELECT * FROM usuarios WHERE idUsuario='$idUsuario';";
        $stmt = Conexion::conectar()->prepare($SQL);
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        $stmt = null;
        if (count($resultado) != 0) {
            echo "success|" . json_encode($resultado);
        } else {
            echo "error|Usuario desconocido !";
        }
    }
    public static function validarAccesos($idUsuario)
    {
        $SQL = "SELECT status FROM usuarios WHERE idUsuario='$idUsuario';";
        $stmt = Conexion::conectar()->prepare($SQL);
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        $stmt = null;
        if (count($resultado) != 0) {
            if ($resultado[0]['status'] == '1') {
                echo "success|Acceso permitido !";
            } elseif ($resultado[0]['status'] == '0') {
                echo "warning|Acceso no permitido !";
            } else {
                echo "error|Estatus invalido ! REVISAR BD";
            }
        } else {
            echo "error|Usuario desconocido !";
        }
    }
    public static function salir()
    {
        session_start();
        session_unset();
        session_destroy();
    }
}
