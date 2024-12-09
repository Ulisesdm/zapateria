<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="description" content="Proyecto">
    <meta name="Author" content="PrograMaster.Inc">
    <meta name="keywords" content="Proyecto,programaster">
    <title>Zapatería Adonay</title>
    
    <!-- Bootstrap CSS -->
    <link href="bootstrap5/css/bootstrap.min.css" rel="stylesheet" >
    <!-- ESTILOS PERSONALIZADOS CSS -->
    <link rel="stylesheet" href="iniciar_sesion/estilos-carga-inicio.css">
    <link rel="stylesheet" href="css/estilos-glass.css">
    <link rel="stylesheet" href="iniciar_sesion/estilos-carga.css">
</head>
<body>
    <section><img src="img/cargando1.gif" alt="carga" class="imagen"></section>
    <h1 class="text-center text-primary mb-2 fw-bold">Cerrando sesión...</h1>
</body>
</html>

<?php

require 'config/config.php';

session_destroy();

?>

<br>
 <?php header("refresh:1; url=index.php"); ?>
</body>