<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="description" content="Proyecto">
    
    <link rel="stylesheet" href="estilos-carga.css">
    <title>Hola estoy cargando...</title>
    <!-- Bootstrap CSS -->
    <link href="../bootstrap5/css/bootstrap.min.css" rel="stylesheet" >
    <link href="../bootstrap5/css/bootstrap.css" rel="stylesheet">
    <!-- ESTILOS PERSONALIZADOS CSS -->
    <link rel="stylesheet" href="../iniciar_sesion/estilos-carga-inicio.css">
    <link rel="stylesheet" href="../css/estilos-glass.css">
</head>
    <section><img src="../img/cargando1.gif" alt="carga" class="imagen"></section>
    <h1 class="text-center text-primary mb-2 fw-bold">Procesando tu compra...</h1>
</body>
</html>

<?php
header("refresh:1; url=../viewindexcompletado.php");
?>