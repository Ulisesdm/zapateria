<?php

require_once '../config/config.php';

$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT idProductos, nombre, precio FROM tablaproductos WHERE activo=1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);


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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body id="bod">

    <!-- Barra de navegacion -->
    <?php include '../navegacion.php'; ?>

    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-12 col-lg-12">
                    <div class="row justify-content-center">
                        <div class="col-sm-12 mt-1">
                            <div id="carouselExampleControls" class="carousel slide" data-interval="corusel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <a href="catalogoadidas.php">
                                            <img src="../img/Publicidad1.jpg" class="d-block w-100" alt="...">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a href="catalogovans.php">
                                            <img src="../img/Publicidad2.jpg" href="" class="d-block w-100" alt="...">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a href="catalogoconverse.php">
                                            <img src="../img/Publicidad6.jpg" href="" class="d-block w-100" alt="...">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a href="catalogonike.php">
                                            <img src="../img/Publicidad3.jpg" href="" class="d-block w-100" alt="...">
                                        </a>
                                    </div>

                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Atrás</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Siguiente</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br><br>
            <div class="row">
                <?php foreach ($resultado as $row) { ?>
                    <div class="col-sm-6 col-md-4 col-lg-3 mt-3">
                        <div class="card text-white bg-primary mb-3">
                            <?php
                            $id = $row['idProductos'];
                            $imagen = "../productos/" . $id . "/principal.jpg";
                            if (!file_exists($imagen)) {
                                $imagen = "../productos/nodisponible.jpg";
                            }
                            ?>
                            <img class="card-img card-img-square" src="<?php echo $imagen; ?>">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $row['nombre']; ?></h4>
                                <h5 class="card-title">$<?php echo number_format($row['precio'], 2, '.', ','); ?></h5>
                                <div class="d-flex justify-content-around">
                                    <a href="../carrito/detalles.php?id=<?php echo $row['idProductos']; ?>&token=<?php echo hash_hmac('sha1', $row['idProductos'], KEY_TOKEN); ?>" class="btn btn-outline-success">Ver detalles</a>
                                    <button class="btn btn-secondary" type="button" onClick="addProducto
                                (<?php echo $row['idProductos']; ?>, '<?php echo hash_hmac('sha1', $row['idProductos'], KEY_TOKEN); ?>')">Agregar al carrito</button>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>



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
                    Swal.fire(
                        'Éxito',
                        'El producto se ha añadido al carrito',
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error',
                        'No hay suficientes existencias',
                        'error'
                    );
                }
            })
    }
</script>

    <footer class="text-center text-primary fixed-bottom mt-5">
        <div class="text-center p-3" id="barraNav">
            © 2023 Copyright:
            <a class="text-primary" href="#">Derechos reservados para Alejandro, Rogelio, Reyna y Gael</a>
        </div>
    </footer>


</body>

</html>