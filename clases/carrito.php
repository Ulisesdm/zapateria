<?php
require '../config/config.php';

$datos['ok'] = false;

if (isset($_POST['id'])) {
    
    $id = $_POST['id'];
    $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 1;
    $token = $_POST['token'];

    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if ($token == $token_tmp && $cantidad > 0 && is_numeric($cantidad) ) {

        $db = new Database();
        $con = $db->conectar();
        $sql = $con->prepare("SELECT stock FROM tablaproductos WHERE idProductos=? AND activo=1 LIMIT 1");
        $sql->execute([$id]);
        $producto = $sql->fetch(PDO::FETCH_ASSOC);
        $stock = $producto['stock'];

        if(isset($_SESSION['carrito']['productos'][$id])) {
            $cantidad += $_SESSION['carrito']['productos'][$id];
        }

        if($stock >= $cantidad){
            $_SESSION['carrito']['productos'][$id] = $cantidad;
            $datos['ok'] = true;
            $datos['numero'] = count($_SESSION['carrito']['productos']);
        } else {
            // If there are not enough stocks, you might want to remove the product from the session
            unset($_SESSION['carrito']['productos'][$id]);
        }
    }
}

echo json_encode($datos);
?>
