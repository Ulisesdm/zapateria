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
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Productos</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
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
                                    <td><input type="number" min="1" max="10" step="1" value="<?php echo $cantidad ?>" size="5" id="cantidad_<?php echo $_idProductos; ?>" onchange="actualizaCantidad(this.value, <?php echo $_idProductos; ?>)">
                                    </td>
                                    <td>
                                        <div id="subtotal_<?php echo $_idProductos; ?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?></div>
                                    </td>
                                    <td><a href="#" id="eliminar" class="btn btn-danger btn-sm" data-bs-id="<?php echo $_idProductos; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal"><i class="fa-solid fa-trash" style="color: #ffffff;"></i> Eliminar</td>
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
                    <?php if(isset($_SESSION['user_cliente'])) { ?>

                    <a href="../carrito/pago.php" class="btn btn-primary btn-lg"> Realizar Pago</a>
                    <?php } else { ?>
                        <a href="../iniciar_sesion/iniciarSesion.php?pago" class="btn btn-primary btn-lg">Para proceder debes iniciar sesión</a>
                    <?php } ?>
                </div>
            <?php } ?>
        <?php } ?>
        </div>
    </main>

    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="eliminaModalLabel">¡Alerta!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Está a punto de eliminar un producto</p>
                </div>
                <div class="modal-footer">
                    <button id="btn-elimina" type="button" class="btn btn-primary" onClick="eliminar()">Aceptar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        let eliminaModal = document.getElementById('eliminaModal')

        eliminaModal.addEventListener('show.bs.modal', function(event) {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
            buttonElimina.value = id
        })

        function actualizaCantidad(cantidad, id) {
            let url = '../clases/actualizar_carrito.php'
            let formData = new FormData()
            formData.append('action', 'agregar')
            formData.append('idProductos', id)
            formData.append('cantidad', cantidad)

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        let divsubtotal = document.getElementById('subtotal_' + id)
                        divsubtotal.innerHTML = data.sub

                        let total = 0.00
                        let list = document.getElementsByName('subtotal[]')

                        for (let i = 0; i < list.length; i++) {
                            total += parseFloat(list[i].innerHTML.replace(/[<?php echo MONEDA ?>,]/g, ''))
                        }
                        total = new Intl.NumberFormat('en-US', {
                            minimumFractionDigits: 2
                        }).format(total)
                        document.getElementById('total').innerHTML = '<?php echo MONEDA ?>' + total
                    } else {
                        let inputCantidad = document.getElementById('cantidad_' + id)
                        inputCantidad.value = data.cantidadAnterior
                    Swal.fire(
                        'Error',
                        'No hay suficientes existencias',
                        'error'
                    );
                }
                })
        }

        function eliminar() {
            let botonElimina = document.getElementById('btn-elimina')
            let id = botonElimina.value

            let url = '../clases/actualizar_carrito.php'
            let formData = new FormData()
            formData.append('action', 'eliminar')
            formData.append('idProductos', id)

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        location.reload()
                    }
                })
        }
    </script>

    <div id="burbujas">
        <div id="burbuja"></div>
        <div id="burbuja"></div>
        <div id="burbuja"></div>
        <div id="burbuja"></div>
    </div>

</body>

</html>