<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atención a denuncias</title>
    <!-- jQuery -->
    <script src="vistas\static\js\jquery-3.5.1.min.js"></script>
    <!-- bootstrap-4.5.2-dist -->
    <link type="text/css" rel="stylesheet" href="vistas\static\bootstrap\css\bootstrap.min.css">
    <script type="text/javascript" src="vistas\static\bootstrap\js\bootstrap.min.js"></script>
    <script src="vistas\static\bootstrap\js\bootstrap.bundle.min.js"></script>
    <!-- Bootswatch - Flatly 
    <link rel="stylesheet" href="vistas\static\bootswatch\bootswatch-flatly.css">-->
    <!-- Bootswatch - Lux -->
    <link rel="stylesheet" href="vistas\static\bootswatch\bootswatch-lux.css">
    <!-- DataTables-1.10.22 -->
    <link rel="stylesheet" href="vistas\static\datatables\datatables.min.css">
    <link rel="stylesheet" href="vistas\static\datatables\DataTables-1.10.22\css\dataTables.bootstrap4.min.css">
    <script src="vistas\static\datatables\datatables.min.js"></script>
    <script src="vistas\static\datatables\Buttons-1.6.4\js\buttons.bootstrap4.min.js"></script>
    <script src="vistas\static\datatables\JSZip-2.5.0\jszip.min.js"></script>
    <script src="vistas\static\datatables\pdfmake-0.1.36\pdfmake.min.js"></script>
    <script src="vistas\static\datatables\pdfmake-0.1.36\vfs_fonts.js"></script>
    <script src="vistas\static\datatables\Buttons-1.6.4\js\buttons.html5.min.js"></script>
    <!-- SweetAlert 2 -->
    <script src="vistas\static\sweetalert\sweetalert2.all.js"></script>
    <!-- Alertify JS 1.13.1 -->
    <link rel="stylesheet" href="vistas\static\alertify\css\alertify.css">
    <link rel="stylesheet" href="vistas\static\alertify\css\themes\default.css">
    <script src="vistas\static\alertify\js\alertify.js"></script>
    <!-- fontawesome-free-5.14.0-web -->
    <link rel="stylesheet" href="vistas\static\fontawesome\css\all.css">
    <script src="vistas\static\fontawesome\js\all.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="vistas\static\css\main.css">
</head>

<body style="background-color: #F0F4F7;">
    <?php
    require_once "./controladores/controladorVistas.php";
    $vt = new controladorVistas();
    $vistasR = $vt->obtenerVistasControlador();
    if ($vistasR == "") {
        require_once "./vistas/templates/login.php";
    } else {
        require_once $vistasR;
    }
    ?>
</body>

</html>