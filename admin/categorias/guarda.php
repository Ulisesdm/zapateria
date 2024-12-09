<?php

require '../config/database.php';
require '../config/config.php';


if (!isset($_SESSION['user_type'])) {
    echo "<script> window.location.href='../index.php'; </script>";
    exit;
}


if ($_SESSION['user_type'] != 'admin') {
    header('Location: ../../viewindex.php');
    exit;
}

$db = new Database();
$con = $db->conectar();

$nombre = $_POST['nombre'];

$sql = $con->prepare("INSERT INTO categorias (nombre, activo) VALUES (?, 1)");
$sql->execute([$nombre]);

header('Location: index.php');

?>