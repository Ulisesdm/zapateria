<?php

require '../config/database.php';
require '../config/config.php';
require '../clases/cifrado.php';


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
$nombre = $_POST['usuario'];
$password = $_POST['password']; // Añadir esta línea para obtener la contraseña del formulario

$passwordBd = '';

if ($passwordBd != $password) {
    $password = cifrar($password, ['key' => 'ABCD.1234-', 'method' => 'aes-128-cbc']);
}

$sql = $con->prepare("UPDATE datos_usuarios SET usuario = ? WHERE id_cliente = ?");
$sql->execute([$nombre, $id]);

if ($passwordBd != $password) {
    $sqlconfig = $con->prepare("SELECT password FROM datos_usuarios WHERE activacion = 1 LIMIT 1");
    $sqlconfig->execute();
    if ($row_config = $sqlconfig->fetch(PDO::FETCH_ASSOC)) {
        $passwordBd = $row_config['password'];
        // Ejecuta la actualización de la contraseña aquí si es necesario
        $sql = $con->prepare("UPDATE datos_usuarios SET password = ? WHERE id_cliente = ?");
        $sql->execute([$password, $id]);
    }
}

header('Location: index.php');


?>

