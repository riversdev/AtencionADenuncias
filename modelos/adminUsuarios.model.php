<?php
require_once 'modeloConexion.php';
class Usuarios
{
    public static function listarAdmins($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            return "error";
        }
        $stmt->close();
        $stmt = null;
    }

    //*********ACTIVAR USUARIO ADMINISTRADOR****************//
    static public function ActivarUsersAdmins($tabla, $item1, $valor1, $item2, $valor2)
    {
        echo '
            <script>
                console.log("' . $valor1 . '");
            </script>
        ';
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");
        $stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
        $stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt->close();
        $stmt = null;
    }
    //*********INSERTAR USUARIO ADMINISTRADOR****************//
    public static function InsertarAdmin($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (usuario, contrasenia, app, apm, email, tel, tipoUsuario, status)VALUES (:nombre,
                                                        :pass,
                                                        :app,
                                                        :apm,
                                                        :email,
                                                        :tel,
                                                        :tipou,
                                                        :status)");

        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":app", $datos["app"], PDO::PARAM_STR);
        $stmt->bindParam(":apm", $datos["apm"], PDO::PARAM_STR);
        $stmt->bindParam(":pass", $datos["pass"], PDO::PARAM_STR);
        $stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
        $stmt->bindParam(":tel", $datos["tel"], PDO::PARAM_STR);
        $stmt->bindParam(":tipou", $datos["tipou"], PDO::PARAM_STR);
        $stmt->bindParam(":status", $datos["status"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt->close();
        $stmt = null;
    }
    public static function verificarEmail($correo)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios WHERE email='$email'");
        if ($stmt->execute()) {
            $res = $stmt->fetchAll();
            $countRes = count($res);
            if ($countRes > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return "Error al realizar la acción";
        }
        $stmt->close();
        $stmt = null;
    }
    //*********ELIMINAR USUARIO ADMINISTRADOR****************//
    public static function EliminarAdmin($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idUsuario=:id");
        $stmt->bindParam(":id", $datos["idAdminEliminar"], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt->close();
        $stmt = null;
    }

    //*********RECUPERAR DATOS USUARIO ADMINISTRADOR****************//
    public static function RecuperarDatosAdmin($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idUsuario= :id");
        $stmt->bindParam(":id", $datos["idAdminEditar"], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            return "error";
        }
        $stmt->close();
        $stmt = null;
    }

    //*********EDITAR USUARIO ADMINISTRADOR****************//
    public static function EditarAdmin($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET usuario = :enombre,
                                                                 contrasenia = :epass,
                                                                 app = :eapp,
                                                                 apm = :eapm,
                                                                 email = :eemail,
                                                                 tel = :etel,
                                                                 tipoUsuario = :etipo
                                                WHERE idUsuario=:clave");
        $stmt->bindParam(":clave", $datos["idAdminEdit"], PDO::PARAM_INT);
        $stmt->bindParam(":enombre", $datos["enombre"], PDO::PARAM_STR);
        $stmt->bindParam(":eapp", $datos["eapp"], PDO::PARAM_STR);
        $stmt->bindParam(":eapm", $datos["eapm"], PDO::PARAM_STR);
        $stmt->bindParam(":epass", $datos["passEdit"], PDO::PARAM_STR);
        $stmt->bindParam(":eemail", $datos["emailEdit"], PDO::PARAM_STR);
        $stmt->bindParam(":etel", $datos["etel"], PDO::PARAM_STR);
        $stmt->bindParam(":etipo", $datos["etipou"], PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt->close();
        $stmt = null;
    }
}
