<?php

$accion = (isset($_GET['accion'])) ? $_GET['accion'] : 'leer';

switch ($accion) {
    case 'guardarInfo':
        # code...
        break;
    
    default:
        echo "success|Leer denuncias...";
        break;
}