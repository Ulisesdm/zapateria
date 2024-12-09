<?php
require_once '../config/config.php';
require_once '../config/database.php';
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
                                    <!-- Apartados tarjetas temas -->
                                    <div class="mt-2 ">
                                        <h1 class="text-center text-light">¡Te presentamos al equipo!</h1>
                                    </div><br>
                                    <div class="carousel-item active">
                                        <a>
                                            <img src="../img/utsempublicidadgratis.jpg" class="d-block w-100" alt="...">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a>
                                            <img src="../img/Publicidad2.jpg" href="" class="d-block w-100" alt="...">
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
            </div><br>

            <div class="container">
                <div class="row align-items-center">
                    <div class="row row-cols-1 row-cols-lg-3 g-3">

                        <div class="col">
                            <div class="card text-white bg-info mb-3">
                                <img src="../img/icecream.png" class="card-img-top w-35" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Seguridad en el sistema</h5>
                                    <p class="card-text">Siendo alumnos de la UTSEM, nos aseguramos de que en el sitio 'Zapatería Adonay' no tengas de que preocuparte por tu seguridad. Cada transacción y movimiento es completamente seguro y 100% real.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card text-white bg-danger mb-3">
                                <img src="../img/recuperar1.png" class="card-img-top w-35" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Actualización de stock</h5>
                                    <p class="card-text">Desarrollamos un sistema que se actualizado todo el tiempo por lo que verás nuestro nuevo inventario.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card text-white bg-success mb-3">
                                <img src="../img/recupera.png" class="card-img-top w-35" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">¡Uso de correo electrónico</h5>
                                    <p class="card-text">Desarrollamos un servicio de mensajería para que puedas usar tu correo de Gmail con toda confianza. Puedes comprobar tu detalles de compra así como ayudar a recuperar tu contraseña.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div><br>

            <!-- ultimo nivel -->
            <div class="mt-2 ">
                <h1 class="text-center text-light">¡Visítanos en nuestra tienda!</h1>
            </div>

            <div class="container mt-5 col-sm-12 mb-4">
                <div class="row justify-content-center">
                    <div class="col-sm-12 col-lg-5 my-auto">
                        <h2 class=" text-center text-light">¡Estamos más cerca de lo que parece!</h2> <br>
                        <p class="text-center text-light">Si tienes cualquier aclaración o detalle puede ser consultado en la zapatería Adonay, abierta de 9:00 AM a 7 PM. Nos puedes contactar en zapateria.adonay2023@gmail.com . Puedes sugerirnos cualquier cosa, estamos para servirte.<br>
                    </div>
                    <div class="col-sm-12 col-lg-5">
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="../img/poster3.jpg" href="" class="d-block w-100" alt="...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br><br>
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
                    }
                })
        }
    </script>

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