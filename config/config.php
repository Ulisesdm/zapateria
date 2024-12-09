<?php

$path = dirname(__FILE__) . DIRECTORY_SEPARATOR;

require_once $path . 'database.php';
require_once $path . '/../admin/clases/cifrado.php';

$db = new Database();
$con = $db->conectar();

$sql = "SELECT nombre, valor FROM configuracion";
$resultado = $con->query($sql);
$datosConfig = $resultado->fetchAll(PDO::FETCH_ASSOC);

$config = [];

foreach($datosConfig as $datoConfig){
    $config[$datoConfig['nombre']] = $datoConfig['valor'];
}


///Configuración del sitio
define("SITE_URL", "http://localhost/html5/ProyectoAdonay");
define("KEY_TOKEN", "ALE123456789");
if (!defined('KEY_CIFRADO')) define('KEY_CIFRADO', 'ABCD.1234-');
define("METODO_CIFRADO", "aes-128-cbc");

define("MONEDA", $config['tienda_moneda']);

//Configuración MERCADO PAGO
//define("TOKEN_MP", $config['mp_token']);
define("TOKEN_MP", "TEST-3805851564127520-102421-4ab81d3b630575480b9bc0495e0e02d6-1522574479");
//define("PUBLIC_KEY_MP", $config['mp_clave']);
//define("LOCALE_MP", "es-MX");

//Configuración Paypal
define("CLIENT_ID", $config['paypal_cliente']);
define("CURRENCY", $config['paypal_moneda']);

//Configuración para envíar correo electrónico

define("MAIL_HOST", $config['correo_smtp']);
define("MAIL_USER", $config['correo_email']);
define("MAIL_PASS", descifrar($config['correo_password']));
define("MAIL_PORT", $config['correo_puerto']);

session_start();
$num_cart=0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}
?>