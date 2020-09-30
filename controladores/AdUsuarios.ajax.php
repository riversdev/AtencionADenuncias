<?php

require_once "../modelos/adminUsuarios.model.php";

class UsersAdmin
{
  public $activarId;
  public $activarAdmins;
  public function ActivarUsersAdmins()
  {
    $tabla = "usuarios";
    $item1 = "status";
    $item2 = "idUsuario";
    $valor1 = $this->activarAdmins;
    $valor2 = $this->activarId;
    $respuesta = Usuarios::ActivarUsersAdmins($tabla, $item1, $valor1, $item2, $valor2);
  }
}

if (isset($_POST["activarAdmins"])) {
  $activarAdmin = new UsersAdmin();
  $activarAdmin->activarAdmins = $_POST["activarAdmins"];
  $activarAdmin->activarId = $_POST["activarId"];
  $activarAdmin->ActivarUsersAdmins();
}


if (isset($_POST["email"])) {
  if (empty($_POST['email'])) {
    echo "Correo electrónico vacio";
  } elseif (!preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/', $_POST['email'])) {
    echo "Correo inválido";
  } elseif (empty($_POST['pass'])) {
    echo "Contraseña vacía";
  } elseif (strlen($_POST['pass']) < 8) {
    echo "La contraseña debe tener como mínimo 8 caracteres";
  } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $_POST["pass"])) {
    echo "El formato de contraseña no coincide";
  } elseif (
    !empty($_POST["email"]) && !empty($_POST['pass'])
  ) {

    $correo = $_POST["email"];
    $veri = Usuarios::verificarEmail($correo);
    if ($veri == true) {
      $errors[] = "El correo electrónico que ingreso ya se encuentra registrado";
    } elseif ($veri == false) {
      $user_password1 = crypt($_POST['pass'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

      $tabla = "usuarios";
      $datos = array(
        "nombre" => $_POST["nombre"],
        "app" => $_POST["app"],
        "apm" => $_POST["apm"],
        "pass" => $user_password1,
        "email" => $_POST["email"],
        "tel" => $_POST["tel"],
        "tipou" => $_POST["tipou"],
        "status" => $_POST["status"]
      );
      $respuesta = Usuarios::InsertarAdmin($tabla, $datos);
      echo $respuesta;
    } else {
      echo "Un error desconocido ocurrió.";
    }
  } else {
    echo "Un error desconocido ocurrió.";
  }
}

if (isset($_POST["id"])) {
  $tabla = "usuarios";
  $datos = array("idAdminEliminar" => $_POST["id"]);
  $respuesta = Usuarios::EliminarAdmin($tabla, $datos);
  echo $respuesta;
}

if (isset($_POST['idback'])) {
  $tabla = "usuarios";
  $datos = array("idAdminEditar" => $_POST["idback"]);
  $respuesta = Usuarios::RecuperarDatosAdmin($tabla, $datos);
  if ($respuesta) {
    $json = array();
    foreach ($respuesta as $key => $value) {
      $json[] = array(
        'idUsuario' => $value['idUsuario'],
        'nombre' => $value['usuario'],
        'pass' => $value['contrasenia'],
        'app' => $value['app'],
        'apm' => $value['apm'],
        'email' => $value['email'],
        'tel' => $value['tel'],
        'tipoU' => $value['tipoUsuario']
      );
    }
    echo $jsonstring = json_encode($json[0]);
  }
}

if (isset($_POST["eemail"])) {
  if ($_POST["eemail"]) {
    if (empty($_POST['epass'])) {
      $tabla = "usuarios";
      $datos = array(
        "idAdminEdit" => $_POST["idu"],
        "enombre" => $_POST["enombre"],
        "eapp" => $_POST["eapp"],
        "eapm" => $_POST["eapm"],
        "passEdit" => $_POST["defi"],
        "emailEdit" => $_POST["eemail"],
        "etel" => $_POST["etel"],
        "etipou" => $_POST["etipou"],
        "estatus" => $_POST["estatus"],
      );
      $respuesta = Usuarios::EditarAdmin($tabla, $datos);
      echo $respuesta;
    } else {
      if (strlen($_POST["epass"]) < 8) {
        echo "La contraseña debe tener como mínimo 8 caracteres";
      } else if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $_POST["epass"])) {
        echo "El formato de contraseña no coincide";
      } else if (!empty($_POST['epass'])) {
        $user_password1 = crypt($_POST['epass'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
        $tabla = "usuarios";
        $datos = array(

          "idAdminEdit" => $_POST["idu"],
          "enombre" => $_POST["enombre"],
          "eapp" => $_POST["eapp"],
          "eapm" => $_POST["eapm"],
          "passEdit" => $user_password1,
          "emailEdit" => $_POST["eemail"],
          "etel" => $_POST["etel"],
          "etipou" => $_POST["etipou"],
        );
        $respuesta = Usuarios::EditarAdmin($tabla, $datos);
        echo $respuesta;
      }
    }
  }
}
