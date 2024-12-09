<?php
require_once '../config/config.php';

$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($id == '' || $token == '') {
    echo 'Error al procesar la petición';
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if ($token == $token_tmp) {
        $sql = $con->prepare("SELECT count(idProductos) FROM tablaproductos WHERE idProductos=? AND activo=1");
        $sql->execute([$id]);
        if ($sql->fetchAll() > 0) {
            $sql = $con->prepare("SELECT nombre, descripcion, precio, descuentos, stock FROM tablaproductos WHERE idProductos=? AND activo=1 LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
            $descuento = $row['descuentos'];
            $stock = $row['stock'];
            $precio_desc = $precio - (($precio * $descuento) / 100);
            $dir_images = '../productos/' . $id . '/';
            $rutaImg = $dir_images . 'principal.jpg';

            if (!file_exists($rutaImg)) {
                $rutaImg = '../productos/nodisponible.jpg';
            }

            $imagenes = array();
            if (file_exists($dir_images)) {
                $dir = dir($dir_images);

                while (($archivo = $dir->read()) != false) {
                    if ($archivo != 'principal.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))) {
                        $imagenes[] = $dir_images . $archivo;
                    }
                }
                $dir->close();

                $sqlTallas = $con->prepare("SELECT DISTINCT t.idtallas, t.nombre FROM productos_variantes AS pv INNER JOIN c_tallas AS t ON pv.id_talla = t.idtallas WHERE pv.id_producto = ?");
                $sqlTallas->execute([$id]);
                $tallas = $sqlTallas->fetchAll(PDO::FETCH_ASSOC);

                $sqlColores = $con->prepare("SELECT DISTINCT c.idcolores, c.nombre FROM productos_variantes AS pv INNER JOIN c_colores AS c ON pv.id_color = c.idcolores WHERE pv.id_producto = ?");
                $sqlColores->execute([$id]);
                $colores = $sqlColores->fetchAll(PDO::FETCH_ASSOC);
            }

            $sqlCaracteristicas = $con->prepare("SELECT DISTINCT(det.idcaracteristicas) AS idCat, cat.caracteristica FROM tabladetallesprod AS det INNER JOIN tablacaracteristicas AS cat ON det.idcaracteristicas = cat.idcaracteristicas WHERE det.idProductos=?");
            $sqlCaracteristicas->execute([$id]);
        }
    } else {
        echo 'Error al procesar';
        exit;
    }
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body id="bod">

    <!-- Barra de navegacion -->
    <?php include '../navegacion.php'; ?>

    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div id="carouselImages" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="<?php echo $rutaImg; ?>" alt="Product Image" class="d-block w-100">
                                    </div>

                                    <?php foreach ($imagenes as $img) { ?>
                                        <div class="carousel-item">
                                            <img src="<?php echo $img; ?>" alt="Product Image" class="d-block w-100">
                                        </div>
                                    <?php } ?>

                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Atras</span>
                                </button>

                                <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <?php if ($colores) { ?>
                        <div class="col-14 my-3" id="div-colores">
                            <label for="colores" class="form-label text-light">Colores:</label>
                            <select class="form-select" name="colores" id="colores">
                                <?php foreach ($colores as $color) { ?>
                                    <option value="<?php echo $color['idcolores'] ?>"><?php echo $color['nombre'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                    <p class="text-light">Precio (Algunos productos pueden variar de precio): </p>
                    <input class="form-control" id="nuevo_precio">
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h2><?php echo $nombre; ?></h2>
                        </div>
                        <div class="card-body">
                            <?php if ($descuento > 0) { ?>
                                <h2>
                                    <del><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></del> -
                                    <?php echo MONEDA . number_format($precio_desc, 2, '.', ','); ?>
                                </h2>
                                <h2 class="text-success"><?php echo $descuento; ?>% de Descuento</h2>

                            <?php } else { ?>
                                <h2><?php echo MONEDA . number_format($precio, 2, '.', '.'); ?></h2>
                            <?php } ?>

                            <p class="lead">
                                <?php echo $descripcion ?>
                            </p>

                            <div class="d-flex justify-content-center">
                                <div class="d-grid gap-3 col-10">

                                    <?php if ($tallas) { ?>
                                        <div class="col-14 my-3">
                                            <label for="tallas" class="form-label">Tallas:</label>
                                            <select class="form-select" name="tallas" id="tallas" onchange="cargarColores()">
                                                <?php foreach ($tallas as $talla) { ?>
                                                    <option value="<?php echo $talla['idtallas'] ?>"><?php echo $talla['nombre'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    <?php } ?>


                                    Cantidad:
                                    <input class="form-control" id="cantidad" name="cantidad" type="number" min="1" max="10" value="1">
                                    <span id="cantidad-error" class="text-danger"></span>
                                    <h4>Stock disponible: <?php echo $stock; ?></h4>
                                    <button class="btn btn-primary" type="button" onclick="window.location.href = 'checkout.php';">Comprar Ahora</button>
                                    <button class="btn btn-outline-primary" type="button" onClick="addProducto(<?php echo $id; ?>, cantidad.value, '<?php echo $token_tmp; ?>')">Agregar al carrito</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var cantidadInput = document.getElementById('cantidad');
            var cantidadError = document.getElementById('cantidad-error');
            var stock = <?php echo $stock; ?>; // Obtener el valor del stock desde PHP

            cantidadInput.addEventListener('change', function() {
                var cantidadIngresada = parseInt(cantidadInput.value);

                if (cantidadIngresada > stock) {
                    cantidadError.textContent = "No hay suficiente stock disponible.";
                    cantidadInput.value = stock; // Restablecer la cantidad al valor máximo del stock
                } else {
                    cantidadError.textContent = ""; // Borrar el mensaje de error si la cantidad es válida
                }
            });
        });
    </script>


    <script>
        function addProducto(id, cantidad, token) {
            var url = '../clases/carrito.php'
            var formData = new FormData()
            formData.append('id', id)
            formData.append('cantidad', cantidad)
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
                    }else{
                        Swal.fire(
                        'Error',
                        'No hay suficientes existencias',
                        'error'
                    );
                    }
                })
        }


        const cbxTallas = document.getElementById('tallas')
        cargarColores()

        const cbxColores = document.getElementById('colores')
        cbxColores.addEventListener('change', cargarVariante, false)


        function cargarColores() {

            let idTalla = 0;

            if(document.getElementById('tallas')){
                idTalla = document.getElementById('tallas').value
            }

            const divColores = document.getElementById('div-colores')
            const cbxColores = document.getElementById('colores')

            var url = '../clases/productosAjax.php'
            var formData = new FormData()
            formData.append('id_producto', '<?php echo $id; ?>');
            formData.append('id_talla', idTalla)
            formData.append('action', 'buscarColoresPorTalla');

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.colores != '') {
                        divColores.style.display = 'block';
                        cbxColores.innerHTML = data.colores;
                    } else {
                        divColores.style.display = 'none';
                        cbxColores.innerHTML = '';
                        cbxColores.value = 0;
                    }
                    cargarVariante()
                })
        }

        function cargarVariante() {

            let idTalla = 0;

            if(document.getElementById('tallas')){
                idTalla = document.getElementById('tallas').value
            }

            let idColor = 0;

            if(document.getElementById('colores')){
                idColor = document.getElementById('colores').value
            }

            var url = '../clases/productosAjax.php';
            var formData = new FormData();
            formData.append('id_producto', '<?php echo $id; ?>');
            if(idTalla !== 0 && idTalla !== ''){
                formData.append('id_talla', idTalla)
            }

            if(idColor !== 0 && idColor !== ''){
                formData.append('id_color', idColor);
            }

            formData.append('action', 'buscarIdVariante');

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if(data.variante != ''){
                        document.getElementById('nuevo_precio').value = data.variante.precio
                    }else{
                        document.getElementById('nuevo_precio').value = 'No se encontró una variante de precio'
                    }
                })
        }
    </script>



</body>

</html>