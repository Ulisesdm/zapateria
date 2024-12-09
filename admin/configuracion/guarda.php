<?php

require '../config/database.php';
require '../config/config.php';
require '../header.php';
require '../clases/cifrado.php';

$db = new Database();
$con = $db->conectar();


$nombre = $_POST['nombre'];
$numero = $_POST['numero'];
$moneda = $_POST['moneda'];

$smtp = $_POST['smtp'];
$puerto = $_POST['puerto'];
$email = $_POST['email'];
$password = $_POST['password'];

$paypal_cliente = $_POST['paypal_cliente'];
$paypal_moneda = $_POST['paypal_moneda'];

$passwordBd = '';
$sqlconfig = $con->query("SELECT valor FROM configuracion WHERE nombre = 'correo_password' LIMIT 1 ");
$sqlconfig->execute();
if($row_config = $sqlconfig->fetch(PDO::FETCH_ASSOC)){
    $passwordBd = $row_config['valor'];
    }

$sql = $con->prepare("UPDATE configuracion SET valor = ? WHERE nombre = ?");
$sql->execute([$nombre, 'tienda_nombre']);
$sql->execute([$numero, 'tienda_numero']);
$sql->execute([$moneda, 'tienda_moneda']);
$sql->execute([$smtp, 'correo_smtp']);
$sql->execute([$puerto, 'correo_puerto']);
$sql->execute([$email, 'correo_email']);
$sql->execute([$paypal_cliente, 'paypal_cliente']);
$sql->execute([$paypal_moneda, 'paypal_moneda']);

if($passwordBd != $password){
    $password = cifrar($password, ['key' => 'ABCD.1234-', 'method' => 'aes-128-cbc']);
    $sql->execute([$password, 'correo_password']);
}
;

?>
    <main>
        <div class="container-fluid px-4">
            <br><h2 class="text-light">Configuracion actualizada</h2>
            <a href="index.php" class="btn btn-secnondary text-light">Regresar</a>
        </div>
    </main>
    <?php include '../footer.php'; ?>