<?php

require '../config/config.php';

if (!isset($_SESSION['user_type'])) {
    echo "<script> window.location.href='../index.php'; </script>";
    exit;
}


if ($_SESSION['user_type'] != 'admin') {
    header('Location: ../../viewindex.php');
    exit;
}

$urlImagen = $_POST['urlImagen'] ?? '';

if($urlImagen !== '' && file_exists($urlImagen)){
    unlink($urlImagen);
}