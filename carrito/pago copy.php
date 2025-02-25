<?php
require '../config/config.php';

$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;


$lista_carrito = array();

if ($productos != null) {
    foreach ($productos as $clave => $cantidad) {

        $sql = $con->prepare("SELECT idProductos, nombre, precio, descuentos, $cantidad AS cantidad FROM tablaproductos WHERE
        idProductos=? AND activo=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
} else {
    header("Location: ../carrito/catalogo.php");
    exit;
}

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
        <div class="container">
            <div class="row">

                <div class="col-6">
                    <h1 class="text-light"> | - - - - - Detalles de pago - - - - - |</h1>
                    <div id="paypal-button-container"></div>
                </div>




                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Productos</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if ($lista_carrito == null) {
                                    echo '<tr><td colspan="5" class="text-center"><b>Lista vacía...</b></td></tr>';
                                } else {
                                    $total = 0;
                                    foreach ($lista_carrito as $producto) {
                                        $_idProductos = $producto['idProductos'];
                                        $nombre = $producto['nombre'];
                                        $precio = $producto['precio'];
                                        $cantidad = $producto['cantidad'];
                                        $descuentos = $producto['descuentos'];
                                        $precio_desc = $precio - (($precio * $descuentos) / 100);
                                        $subtotal = $cantidad * $precio_desc;
                                        $total += $subtotal; ?>
                                        <tr>
                                            <td><?php echo $nombre; ?></td>
                                            <td><?php echo MONEDA . number_format($precio_desc, 2, '.', ','); ?></td>
                                        </tr>

                            </tbody>
                        <?php } ?>
                        </table>
                    </div>

                    <?php if ($lista_carrito !== null) { ?>
                        <div class="row justify-content-center"> <!-- Añadimos "justify-content-center" para centrar horizontalmente la tarjeta -->
                            <div class="card">
                                <div class="card-header text-center">
                                    Tu total a pagar es:
                                </div>
                                <div class="card-content text-center"> <!-- Añadimos "text-center" para centrar horizontalmente el contenido de la tarjeta -->
                                    <p class="h2" id="total"><?php echo MONEDA . number_format($total, 2, '.', ','); ?></p>
                                </div>
                            </div>
                            <div class="col-md-5 offset-md-7 d-grid gap-2"></div><br>
                        </div>
                    <?php } ?>
                <?php } ?>
                </div>
            </div>
        </div>
    </main>

    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&currency=<?php echo CURRENCY; ?>"></script>

    <!-- SCRIPTS DE AKE NO ROBAR PERROS PERROS PERROS-->

    <script>
        paypal.Buttons({
            style: {
                color: 'gold',
                shape: 'pill',
                label: 'pay'
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: <?php echo $total; ?>
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {

                let url = '../clases/captura.php'

                actions.order.capture().then(function(detalles) {
                    console.log(detalles)

                    return fetch(url, {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            detalles: detalles
                        })
                    }).then(function(response) {
                        window.location.href = "../viewindexcompletado.php?key=" + detalles['id']; //$datos['detalles']['id'];
                    })
                });
            },

            onCancel: function(data) {
                alert("Pago cancelado");
                console.log(data);
            }
        }).render('#paypal-button-container');
    </script>

    <div id="burbujas">
        <div id="burbuja"></div>
        <div id="burbuja"></div>
        <div id="burbuja"></div>
        <div id="burbuja"></div>
    </div>
</body>

</html>