<?php
require 'config/database.php';
require 'clases/adminFunciones.php';

$db = new Database();
$con = $db->conectar();
$errors = [];

//$password = password_hash('admin', PASSWORD_DEFAULT);
//$sql = "INSERT INTO admin (usuario, password, nombre, email, activo, fecha_alta)
//VALUES ('admin','$password','Administrador','mich3000mich@gmail.com','1',NOW())";
//$con->query($sql);

if(!empty($_POST)){
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    if(esNulo([$usuario, $password])){
        $errors[] = "Debe llenar todos los campos";
    }
    if(count($errors) == 0){
        $errors[] = login($usuario, $password, $con);
    }
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="description" content="Proyecto">
    
    <link rel="stylesheet" href="css/estilos-carga.css">
    <title>Hola estoy cargando...</title>
    <!-- Bootstrap CSS -->
    <link href="../bootstrap5/css/bootstrap.min.css" rel="stylesheet" >
    <link href="../bootstrap5/css/bootstrap.css" rel="stylesheet">
    <!-- ESTILOS PERSONALIZADOS CSS -->
    <link rel="stylesheet" href="css/estilos-carga-inicio.css">
    <link rel="stylesheet" href="css/estilos-glass.css">
</head>
    <section><img src="../img/admin.gif" alt="carga" class="imagen"></section>
    <h1 class="text-center text-primary mb-2 fw-bold">Iniciando sesión como administrador...</h1>
</body>
</html>

<?php

header("refresh:1; url=inicio.php");
?>