<?php

require '../config/database.php';
require '../config/config.php';
require '../header.php';
require '../clases/cifrado.php';

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

$sql = "SELECT nombre, valor FROM configuracion";
$resultado = $con->query($sql);
$datos = $resultado->fetchAll(PDO::FETCH_ASSOC);

$config = [];

foreach ($datos as $dato) {
    $config[$dato['nombre']] = $dato['valor'];
}

?>


<main>
    <div class="container-fluid px-4"><br>
        <h1 class="text-light">Configuración</h1>
        <form action="guarda.php" method="post">
            <ul class="nav nav-tabs" id="myTabs" role="tablist">
                <li class="nav-item" role="presentation"><br>
                    <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Config. Tienda</a>
                </li>
                <li class="nav-item" role="presentation"><br>
                    <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Config. Correo</a>
                </li>
                <li class="nav-item" role="presentation"><br>
                    <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">Config. Paypal</a>
                </li>
                <li class="nav-item" role="presentation"><br>
                    <a class="nav-link disabled" id="tab4-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false">Config. Mercado Pago</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabsContent">

                <!-- Contenido de la primera pestaña -->
                <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab"><br>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="nombre" class="text-light">Nombre:</label>
                            <input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $config['tienda_nombre'] ?>">
                        </div>

                        <div class="col-6">
                            <label for="numero" class="text-light">Teléfono:</label>
                            <input class="form-control" type="text" name="numero" id="numero" value="<?php echo $config['tienda_numero'] ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="moneda" class="text-light">Moneda:</label>
                            <input class="form-control" type="text" name="moneda" id="moneda" value="<?php echo $config['tienda_moneda'] ?>">
                        </div>
                    </div>
                </div>

                <!-- Contenido de la segunda pestaña -->
                <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab"><br>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="smtp" class="text-light">SMTP:</label>
                            <input class="form-control" type="text" name="smtp" id="smtp" value="<?php echo $config['correo_smtp'] ?>">
                        </div>

                        <div class="col-6">
                            <label for="puerto" class="text-light">Puerto:</label>
                            <input class="form-control" type="text" name="puerto" id="puerto" value="<?php echo $config['correo_puerto'] ?>">
                        </div>

                        <div class="col-6">
                            <label for="email" class="text-light">Correo electrónico:</label>
                            <input class="form-control" type="email" name="email" id="email" value="<?php echo $config['correo_email'] ?>">

                        </div>

                        <div class="col-6">
                            <label for="password" class="text-light">Contraseña:</label>
                            <input class="form-control" type="password" name="password" id="password" value="<?php echo $config['correo_password'] ?>">
                        </div>

                    </div>

                </div>

                <!-- Contenido de la tercer pestaña -->
                <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab"><br>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="paypal_cliente" class="text-light">ID del Cliente:</label>
                            <input class="form-control" type="text" name="paypal_cliente" id="paypal_cliente" value="<?php echo $config['paypal_cliente'] ?>">
                        </div>

                        <div class="col-6">
                            <label for="paypal_moneda" class="text-light">Moneda:</label>
                            <input class="form-control" type="text" name="paypal_moneda" id="paypal_moneda" value="<?php echo $config['paypal_moneda'] ?>">
                        </div>
                    </div>
                </div>

                <!-- Contenido de la tercer pestaña
                <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab"><br>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="mp_token" class="text-light">Token:</label>
                            <input class="form-control" type="text" name="mp_token" id="mp_token" value="<?php echo $config['mp_token'] ?>">
                        </div>

                        <div class="col-6">
                            <label for="mp_clave" class="text-light">Clave pública:</label>
                            <input class="form-control" type="text" name="mp_clave" id="mp_clave" value="<?php echo $config['mp_clave'] ?>">
                        </div>
                    </div>
                </div>
                 -->


            </div>


            <div class="row mt-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>

    </div>
</main>
<?php

require '../footer.php';

?>