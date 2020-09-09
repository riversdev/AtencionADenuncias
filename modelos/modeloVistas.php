<?php
class modeloVistas
{
    static protected function obtenerVistasModelo($vistas)
    {
        $listaBlanca = ["home"];
        if (in_array($vistas, $listaBlanca)) {
            if (is_file("./vistas/templates/" . $vistas . ".php")) {
                $contenido = "./vistas/templates/" . $vistas . ".php";
            } else {
                $contenido = "";
            }
        } else {
            $contenido = "";
        }
        return $contenido;
    }
}
