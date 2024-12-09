    <?php include 'config/config.php'; ?>
    <?php include 'config/database.php'; ?>
    <?php include 'header.php'; ?>
<?php
    if (!isset($_SESSION['user_type'])) {
    echo "<script> window.location.href='../index.php'; </script>";
    exit;
}


if ($_SESSION['user_type'] != 'admin') {
    header('Location: ../../viewindex.php');
    exit;
}

    $db = new Database();
    $con = $db->conectar();

    $sql = "SELECT idProductos, nombre, descripcion, precio, descuentos, stock, idCategoria FROM tablaproductos WHERE activo = 1 LIMIT 10";
    $resultado = $con->query($sql);
    $productos = $resultado->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT idusuario, usuario, activacion, id_cliente FROM datos_usuarios WHERE activacion = 1 LIMIT 10";
    $resultado1 = $con->query($sql);
    $usuarios = $resultado1->fetchAll(PDO::FETCH_ASSOC);
    
    ?>

<style>
  .custom-card {
    border: 3.5px solid #e1e1e1;
    border-radius: 10px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.4); /* Cambiado el valor de opacidad aquí */
    transition: box-shadow 0.1s;
  }

  .custom-card:hover {
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.6); /* Cambiado el valor de opacidad aquí */
  }

  .card-img-top {
    border-radius: 10px 10px 0 0;
  }
</style>


    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 text-white">Dashboard - Adonay</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Bienvenido a Zapatería ADONAY</li>
            </ol>
            <div class="row">
            <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4 custom-card" id="bod">
            <div class="card-body">
                <img src="images/admin.gif" alt="Imagen de la tarjeta" class="card-img-top">
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?php echo ADMIN_URL;?>configuracion">Configuración del sistema</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4 custom-card" id="bod">
            <div class="card-body"><br>
                <img src="images/admin1.gif" alt="Imagen de la tarjeta" class="card-img-top">
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?php echo ADMIN_URL;?>categorias">Proveedores</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-secondary text-white mb-4 custom-card" id="bod">
            <div class="card-body"><br>
                <img src="images/admin2.gif" alt="Imagen de la tarjeta" class="card-img-top">
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?php echo ADMIN_URL;?>productos">Administración de productos</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4 custom-card" id="bod">
            <div class="card-body"><br>
                <img src="images/admin3.gif" alt="Imagen de la tarjeta" class="card-img-top">
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?php echo ADMIN_URL;?>usuarios">Administración de usuarios</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Top 10 productos más vendidos en Adonay:
                        </div>

                        <div class="table-responsive">
                            <table class="table table-secondary">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($productos as $producto) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES); ?></td>
                                            <td>$<?php echo $producto['precio']; ?></td>
                                            <td><?php echo $producto['stock']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Últimos usuarios registrados:
                        </div>
                        <div class="table-responsive">
                            <table class="table table-secondary">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre del usuario</th>
                                        <th scope="col">ID del cliente</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($usuarios as $usuario) { ?>
                                        <tr>
                                            <td><?php echo $usuario['usuario']; ?></td>
                                            <td><?php echo $usuario['id_cliente']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <?php include 'footer.php'; ?>