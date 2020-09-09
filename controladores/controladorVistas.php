<?php

require_once "./modelos/modeloVistas.php";

class controladorVistas extends modeloVistas
{
    public function obtenerPlantillaControlador()
    {
        return require_once "./vistas/layout.php";
    }
    public function obtenerVistasControlador()
    {
        if (isset($_GET['vistas'])) {
            $ruta = explode("/", $_GET['vistas']);
            $respuesta = modeloVistas::obtenerVistasModelo($ruta[0]);
        } else {
            $respuesta = "";
        }
        return $respuesta;
    }
}
