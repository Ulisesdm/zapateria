<?php
require_once '../config/config.php';
require_once '../clases/clienteFunciones.php';

$db = new Database();
$con = $db->conectar();

$token = generarToken();
$_SESSION['token'] = $token;

$idCliente = $_SESSION['user_cliente'];

$sql = $con->prepare("SELECT id_transaccion, fecha, status, total FROM tablacompras WHERE id_cliente = ? ORDER BY DATE (fecha) DESC");
$sql->execute([$idCliente]);
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
            <div class="row justify-content-center">
                <div class="col-sm-12 col-lg-12">
                    <h1 class="mt-3 text-light text-center">- - - - MIS COMPRAS - - - -</h1> <br>
                </div>

                <?php while($row = $sql->fetch(PDO::FETCH_ASSOC)){ ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <?php echo $row['fecha']?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Folio: <?php echo $row['id_transaccion']; ?></h5>
                        <p class="card-text">Total: $<?php echo $row['total']; ?></p>
                        <p class="card-text">Estatus de la compra: <?php echo $row['status']; ?></p>
                        <a href="compraDetalles.php?orden=<?php echo $row['id_transaccion']; ?>&token=<?php echo $token; ?>" class="btn btn-primary">Ver compra</a>
                    </div>
                </div>
                <?php } ?>

            </div><br><br>
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