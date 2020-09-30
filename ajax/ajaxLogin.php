<?php
require_once "../modelos/modeloLogin.php";

$tipoPeticion = $_POST['tipoPeticion'];

if ($tipoPeticion == "identificacion") {
    Login::identificarUsuario($_POST['txtUsuario'], $_POST['txtPassword']);
} elseif ($tipoPeticion == "validarPermisos") {
    Login::validarPermisos($_POST['idUsuario']);
} elseif ($tipoPeticion == "validarAccesos") {
    Login::validarAccesos($_POST['idUsuario']);
} elseif ($tipoPeticion == "salir") {
    Login::salir();
}
