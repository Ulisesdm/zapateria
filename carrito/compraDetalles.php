<?php
require '../config/config.php';
require '../clases/clienteFunciones.php';

$token_session = $_SESSION['token'];
$orden = $_GET['orden'] ?? null;
$token = $_GET['token'] ?? null;

if ($orden == null || $token  == null || $token != $token_session) {
    header("Location: compras.php");
}

$db = new Database();
$con = $db->conectar();

$sqlCompra = $con->prepare("SELECT id, id_transaccion, fecha, total FROM tablacompras WHERE id_transaccion = ? LIMIT 1");
$sqlCompra->execute([$orden]);
$rowCompra = $sqlCompra->fetch(PDO::FETCH_ASSOC);
$idCompra = $rowCompra['id'];

$fecha = new DateTime($rowCompra['fecha']);
$fecha = $fecha->format('d-m-Y H:i');

$sqlDetalle = $con->prepare("SELECT iddetalle, nombre, precio, cantidad FROM tabladetalles WHERE id_compra = ?");
$sqlDetalle->execute([$idCompra]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ESTILOS PERSONALIZADOS CSS -->
    <link rel="stylesheet" href="../css/estilos-glass.css">
    <link href="../bootstrap5/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrap5/css/bootstrap.css" rel="stylesheet">
    <link href="../fontawesome/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos-glass.css">
    <!-- Bootstrap CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Zapatería Adonay</title>
    <!-- Bootstrap Java -->
    <script src="../jquery/jquery-3.5.1.min.js"></script>
    <script src="../bootstrap5/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="../css/estilosmain.css">
</head>

<body id="bod">

    <!-- Barra de navegacion -->
    <?php include '../navegacion.php'; ?>

    <main>
        <div class="container"><br>
            <div class="row">
                <div class="col-4">
                    <div class="card mb-6">
                        <div class="card-header">
                            <h2>Detalle de la compra</h2>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><strong>Fecha: </strong><?php echo $fecha; ?></h4>
                            <h4 class="card-title"><strong>Orden: </strong><?php echo $rowCompra['id_transaccion']; ?></h4>
                            <h4 class="card-title"><strong>Total: </strong><?php echo MONEDA . number_format($rowCompra['total'], 2, '.', ','); ?></h4>

                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-8">
                    <div class="table-responsive">
                        <table class="table primary">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($row = $sqlDetalle->fetch(PDO::FETCH_ASSOC)) {
                                    $precio = $row['precio'];
                                    $cantidad = $row['cantidad'];
                                    $subtotal = $precio * $cantidad; ?>


                                    <tr>
                                        <td><?php echo $row['nombre'] ?></td>
                                        <td><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></td>
                                        <td><?php echo $cantidad; ?></td>
                                        <td><?php echo $subtotal; ?></td>
                                    </tr>

                                <?php } ?>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div><br><br>
        </div>
        </div>
    </main>


    <footer class="text-center text-primary fixed-bottom mt-5">
        <div class="text-center p-3" id="barraNav">
            © 2023 Copyright:
            <a class="text-primary" href="#">Derechos reservados para Alejandro, Rogelio, Reyna</a>
        </div>
    </footer>
    <div id="burbujas">
        <div id="burbuja"></div>
        <div id="burbuja"></div>
        <div id="burbuja"></div>
        <div id="burbuja"></div>
    </div>

</body>

</html>