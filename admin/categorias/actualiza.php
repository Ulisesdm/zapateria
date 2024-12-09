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

$id = $_POST['id'];
$nombre = $_POST['nombre'];

$sql = $con->prepare("UPDATE categorias SET nombre= ? WHERE idcategoria = ?");
$sql->execute([$nombre, $id]);

header('Location: index.php');

?>