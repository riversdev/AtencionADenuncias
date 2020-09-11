<?php
session_start();

require_once "modeloConexion.php";

class Login
{
    public static function identificarUsuario($usuario, $contrasenia)
    {
        $SQL = "SELECT idUsuario, contrasenia FROM usuarios WHERE usuario='$usuario';";
        $stmt = Conexion::conectar()->prepare($SQL);
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        if (count($resultado) > 0 && password_verify($contrasenia, $resultado[0]['contrasenia'])) {
            $_SESSION['user_id'] = $resultado[0]['idUsuario'];
            echo "success| ";
        } else {
            echo "error|Verifica tus datos!";
        }
        $stmt = null;
    }
    public static function salir()
    {
        session_start();
        session_unset();
        session_destroy();
    }
}
