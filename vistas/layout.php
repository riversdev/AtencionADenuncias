<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denuncias</title>
    <!-- bootstrap-4.5.2-dist -->
    <link type="text/css" rel="stylesheet" href="vistas\static\bootstrap\css\bootstrap.min.css">
    <script type="text/javascript" src="vistas\static\bootstrap\js\bootstrap.min.js"></script>
    <script src="vistas\static\bootstrap\js\bootstrap.bundle.min.js"></script>
    <!-- fontawesome-free-5.14.0-web -->
    <link rel="stylesheet" href="vistas\static\fontawesome\css\all.css">
    <script src="vistas\static\fontawesome\js\all.js"></script>
    <!-- Alertify JS 1.13.1 -->
    <link rel="stylesheet" href="vistas\static\alertify\css\alertify.css">
    <link rel="stylesheet" href="vistas\static\alertify\css\themes\default.css">
    <script src="vistas\static\alertify\js\alertify.js"></script>
</head>

<body>
    <?php
    require_once "./controladores/controladorVistas.php";
    $vt = new controladorVistas();
    $vistasR = $vt->obtenerVistasControlador();
    if ($vistasR == "") {
        require_once "./vistas/templates/welcome.php";
    } else {
        require_once $vistasR;
    }
    ?>
</body>

</html>