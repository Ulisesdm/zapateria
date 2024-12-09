<?php

require '../config/config.php';

$db = new Database();
$con = $db->conectar();

$id_transaccion = isset($_GET['payment_id']) ? $_GET['payment_id'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';


function restarStock($id, $cantidad, $con)
{
    $sql = $con->prepare("UPDATE tablaproductos SET stock = stock - ? WHERE idProductos = ?");
    $sql->execute([$cantidad, $id]);
}


if ($id_transaccion != '') {

    $fecha = date('Y-m-d H:i:s');
    $total = isset($_SESSION['carrito']['total']) ? $_SESSION['carrito']['total'] : 0;
    $idCliente = $_SESSION['user_cliente'];
    // Definir $sqlProd antes de usarlo
    $sql = $con->prepare("SELECT email FROM tablaclientes WHERE idclientes=? AND status=1");
    $sql->execute([$idCliente]);
    $row_cliente = $sql->fetch(PDO::FETCH_ASSOC);

    $email = $row_cliente['email'];

    $sql = $con->prepare("INSERT INTO tablacompras (fecha, status, email, id_cliente, total, id_transaccion, medio_pago) VALUES(?, ?, ?, ?, ?, ?, ?)");
    $sql->execute([$fecha, $status, $email, $idCliente, $total, $id_transaccion, 'MP']);
    $id = $con->lastInsertId();

    if ($id > 0) {
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
                if ($sql_insert->execute([$id, $row_prod['idProductos'], $row_prod['nombre'], $precio_desc, $cantidad])) {
                    restarStock($row_prod['idProductos'], $cantidad, $con);
                }
            }

            require 'mailer.php';

            $asunto = "Detalles de su pedido";
            $cuerpo = '<h4>¡Gracias por comprar en Zapatería Adonay!</h4>';
            $cuerpo .= '<p>No olvides que puedes ver el detalle de la compra desde tu cuenta.</p>';
            $cuerpo .= '<p>¡Te avisaremos cuando tu pedido esté listo para ser enviado!</p>';
            $cuerpo .= '<p>El id de su compra es <b>' . $id_transaccion . '<b/></p>';

            $mailer = new Mailer();
            $mailer->enviarEmail($email, $asunto, $cuerpo);
        }
        unset($_SESSION['carrito']);
        header("Location: " . SITE_URL . "/viewindexcompletado.php?key=" . $id_transaccion);
    }

}
