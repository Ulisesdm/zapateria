<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../clases/clienteFunciones.php';

$db = new Database();
$con = $db->conectar();
$errors = [];

$proceso = isset($_GET['pago']) ? 'pago' : 'login';

if (!empty($_POST)) {

    $usuario = trim($_POST['txtus']);
    $password = trim($_POST['txtcon']);

    if (esNulo([$usuario, $password])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (count($errors) == 0) {
        $errors[] = login($usuario, $password, $con, $proceso);
    }
}

?>

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
    <h1 class="text-center text-primary mb-2 fw-bold">Iniciando sesión...</h1>
</body>
</html>

<?php

header("refresh:1; url=../carrito/catalogo.php");
?>