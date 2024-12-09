<?php
require 'config/config.php';

$db = new Database();
$con = $db->conectar();
$id_transaccion = isset($_GET['key']) ? $_GET['key'] : '0';

$error = '';

if ($id_transaccion == '') {
    $error = 'Error al procesar la petición';
} else {
    // Consulta para contar las compras con el id_transaccion y que tengan status 'COMPLETED' o 'APPROVED'
    $sql = $con->prepare("SELECT count(id) FROM tablacompras WHERE id_transaccion=? AND (status='COMPLETED' OR status='approved')");
    $sql->execute([$id_transaccion]);
    
    if ($sql->fetchColumn() > 0) {
        // Consulta para obtener la primera compra con el id_transaccion y que tenga status 'COMPLETED' o 'APPROVED'
        $sql = $con->prepare("SELECT id, fecha, email, total FROM tablacompras WHERE id_transaccion=? AND (status='COMPLETED' OR status='approved') LIMIT 1");
        $sql->execute([$id_transaccion]);
        $row = $sql->fetch(PDO::FETCH_ASSOC);

        $idCompra = $row['id'];
        $total = $row['total'];
        $fecha = $row['fecha'];
        
        // Consulta para obtener los detalles de la compra
        $sqlDet = $con->prepare("SELECT nombre, precio, cantidad FROM tabladetalles WHERE id_compra = ?");
        $sqlDet->execute([$idCompra]);
    } else {
        $error = 'Error al comprobar la compra';
    }
}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ESTILOS PERSONALIZADOS CSS -->
    <link rel="stylesheet" href="css/estilos-glass.css">
    <link href="bootstrap5/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap5/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos-glass.css">
    <link href="fontawesome/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <title>Zapatería Adonay</title>
    <!-- Bootstrap Java -->
    <script src="jquery/jquery-3.5.1.min.js"></script>
    <script src="bootstrap5/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="css/estilosmain.css">
</head>


<body id="bod">


    <!-- Barra de navegacion -->
    <?php include 'navegacioncompletado.php'; ?>


    <main>
        <div class="container">
            <?php if (strlen($error) > 0) { ?>
            <div class="d-flex justify-content-end"> <!-- Utilizamos flexbox y justify-content-end para alinear el botón hacia la derecha -->
                <h1 class="mt-5 text-light text-center"><?php echo $error; ?></h1>
            </div>
            <?php } else { ?>
            <h1 class="mt-2 text-light text-center">¡Gracias por comprar en Zapatería ADONAY!</h1>
            <p class="mb-3 text-light text-center">Aquí tienes el detalle de tu compra:</p>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr class="table-active">
                            <th>Cantidad</th>
                            <th>Producto</th>
                            <th>Importe</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($row_det = $sqlDet->fetch(PDO::FETCH_ASSOC)) { $importe = $row_det['precio'] * $row_det['cantidad']; ?>
                        <td><?php echo $row_det['cantidad'] ?></td>
                        <td><?php echo $row_det['nombre'] ?></td>
                        <td><?php echo $importe ?></td>
                    </tbody>
                <?php } ?>
                </table>
            </div>

            <div class="row justify-content-center"> <!-- Añadimos "justify-content-center" para centrar horizontalmente la tarjeta -->
                <div class="card">
                    <div class="card-header text-center">
                        Tu total a pagar es:
                    </div>
                    <div class="card-content text-center"> <!-- Añadimos "text-center" para centrar horizontalmente el contenido de la tarjeta -->
                        <p class="h2"><?php echo MONEDA . number_format($total, 2, '.', ','); ?></p>
                        <p class="h2">Folio de la compra: <?php echo $id_transaccion ?></p>
                        <p class="h2">Fecha de la compra: <?php echo $fecha ?></p>
                    </div>
                </div>
                <div class="col-md-5 offset-md-7 d-grid gap-2"></div><br>
                <a href="carrito/catalogo.php" class="btn btn-primary btn-lg">Regresar a la pantalla de Inicio</a> -
                <button onclick="descargarPDFNavegador()" class="btn btn-primary btn-lg">Descargar PDF del Navegador</button>
            </div>
            <?php } ?>
        </div>
    </main>

    <!-- Apartados tarjetas temas -->

    <!-- Pie de pagina -->
    
    <div id="burbujas">
        <div id="burbuja"></div>
        <div id="burbuja"></div>
        <div id="burbuja"></div>
        <div id="burbuja"></div>
    </div>

    <script>
        function addProducto(id, token) {
            let url = '../clases/carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('token', token)

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        let elemento = document.getElementById("num_cart")
                        elemento.innerHTML = data.numero
                    }
                })
        }
    </script>

<script>
    function descargarPDFNavegador() {
        window.print(); // Activa la funcionalidad de impresión del navegador para descargar como PDF
    }
</script>

</body>

</html>