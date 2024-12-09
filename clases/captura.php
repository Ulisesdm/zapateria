<?php

require '../config/config.php';

$db = new Database();
$con = $db->conectar();

$json = file_get_contents('php://input');
$datos = json_decode($json, true);

print_r($datos);

if (is_array($datos)) {


    $idCliente = $_SESSION['user_cliente'];
    $sql = $con->prepare("SELECT email FROM tablaclientes WHERE idclientes=? AND status=1");
    $sql->execute([$idCliente]);
    $row_cliente = $sql->fetch(PDO::FETCH_ASSOC);

    $id_transaccion = $datos['detalles']['id'];
    $total = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $status = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
    $email = $row_cliente['email'];

    //$email = $datos['detalles']['payer']['email_address'];
    //$id_cliente = $datos['detalles']['payer']['payer_id'];

    $sql = $con->prepare("INSERT INTO tablacompras (id_transaccion, fecha, status, email, id_cliente, total, medio_pago) VALUES (?,?,?,?,?,?,?)");
    $sql->execute([$id_transaccion, $fecha_nueva, $status, $email, $idCliente, $total, 'Paypal']);
    $id = $con->lastInsertId();

    if($id > 0){
        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
        if ($productos != null) {
            foreach ($productos as $clave => $cantidad) {
        
                $sql = $con->prepare("SELECT idProductos, nombre, precio, descuentos FROM tablaproductos WHERE idProductos=? AND activo=1");
                $sql->execute([$clave]);
                $row_prod = $sql->fetch(PDO::FETCH_ASSOC);

                $precio = $row_prod['precio'];
                $descuentos = $row_prod['descuentos'];
                $precio_desc = $precio - (($precio * $descuentos) / 100);

                $sql_insert = $con->prepare("INSERT INTO tabladetalles(id_compra, id_producto, nombre, precio, cantidad) VALUES (?,?,?,?,?)");
                if($sql_insert->execute([$id, $row_prod['idProductos'], $row_prod['nombre'], $precio_desc, $cantidad])){
                    restarStock($row_prod['idProductos'], $cantidad, $con);
                }

            }
            require 'mailer.php';

            $asunto = "Detalles de su pedido";
            $cuerpo = '<h4>¡Gracias por comprar en Zapatería Adonay!</h4>';            
            $cuerpo = '<p>No olvides que puedes ver el detalle de la compra desde tu cuenta.</p>';
            $cuerpo ='<p>¡Te avisaremos cuando tu pedido esté listo para ser enviado!</p>';
            $cuerpo .= '<p>El id de su compra es <b>'. $id_transaccion .'<b/></p>';

            $mailer = new Mailer();
            $mailer->enviarEmail($email, $asunto, $cuerpo);
        }
        unset($_SESSION['carrito']);
    }

}


function restarStock($id, $cantidad, $con){
    $sql = $con->prepare("UPDATE tablaproductos SET stock = stock - ? WHERE idProductos = ?");
    $sql->execute([$cantidad, $id]);
}