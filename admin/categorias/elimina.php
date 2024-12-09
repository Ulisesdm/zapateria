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

$sql = $con->prepare("UPDATE categorias SET activo = 0 WHERE idcategoria = ?");
$sql->execute([$id]);

header('Location: index.php');

?>