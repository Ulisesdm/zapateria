<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../clases/clienteFunciones.php';

$db = new Database();
$con = $db->conectar();
$errors = [];

$proceso = isset($_GET['pago']) ? 'pago' : 'login';

if (!empty($_POST)) {

    $usuario = trim($_POST['txtus']);
    $password = trim($_POST['txtcon']);
    $proceso = $_POST['proceso'] ?? 'login';

    if (esNulo([$usuario, $password])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (count($errors) == 0) {
        $errors[] = login($usuario, $password, $con, $proceso);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="../bootstrap5/css/bootstrap.min.css" rel="stylesheet">
  <!-- ESTILOS PERSONALIZADOS CSS -->
  <link rel="shortcut icon" href="../img/kanye.ico">
  <link rel="stylesheet" href="../iniciar_sesion/estilos-carga-inicio.css">
  <link rel="stylesheet" href="../css/estilos-glass.css">
  <link href="../bootstrap5/css/bootstrap.css" rel="stylesheet">
  <!-- JS AJAX -->
  <script src="../js/jquery-3.5.1/jquery.min.js"></script>
  <!-- CSS Y JS SWEET ALERT 2 -->
  <script src="../js/sweetalert2@11/sweetalert2.js"></script>
  <link href="../fontawesome/css/all.min.css" rel="stylesheet">
  <title>Zapatería Adonay</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/estilosmain.css">
</head>

<body id="bod">

    <!-- Barra de navegacion -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="barraNav">
    <div class="container-fluid">
      <img src="../img/logo2.png" alt="" width="55" height="40" class="d-inline-block align-text-top">
      <a class="navbar-brand" href="#">Zapatería Adonay</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active mx-2" aria-current="page" href="../carrito/catalogo.php">Ver todos los productos</a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Ver por categorías
            </a>

            <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarDarkDropdownMenuLink">
              <li><a class="dropdown-item" href="../carrito/catalogoadidas.php">Adidas</a></li>
              <li><a class="dropdown-item" href="../carrito/catalogonike.php">Nike</a></li>
              <li><a class="dropdown-item" href="../carrito/catalogoskechers.php">Skechers</a></li>
              <li><a class="dropdown-item" href="../carrito/catalogovans.php">Vans</a></li>
            </ul>

          </li>

          <li class="nav-item">
            <a class="nav-link mx-2 active" aria-current="page" href="carritonuevo/nuevoCarrito.php">Quiénes sómos</a>
          </li>

        </ul>
      </div>
      <?php if (isset($_SESSION['user_id'])) { ?>

        <div class="d-flex d-sm-none d-lg-block">

        <li class="btn btn-primary nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user-group" style="color: #ffffff;"></i> Mi cuenta</a>

            <ul class="dropdown-menu dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
              <li><a class="dropdown-item" href="#"><i class="fa-regular fa-user"></i> <?php echo $_SESSION['user_name']; ?></a></li>
              <li><a class="dropdown-item" href="../cerrar.php"><i class="fa-solid fa-xmark fa-beat"></i> Cerrar Sesión</a></li>
            </ul>

          </li>
        </div>

      <?php } else { ?>


        <div class="d-flex d-sm-none d-lg-block">
          <a class="btn btn-primary mx-2" href="../registrar/registrar.php"><i class="fa-solid fa-align-justify fa-beat" style="color: #ffffff;"></i> Registrarse</a>
        </div>
      <?php } ?>

      <div class="d-flex d-sm-none d-lg-block">
        <a class="btn btn-primary mx-2" href="../carrito/checkout.php"><i class="fa-solid fa-cart-shopping fa-beat" style="color: #ffffff;"></i> Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart ?></span></a>
      </div>


    </div>
  </nav>

    <main>
        <div class="container">
            <div class="container mt-2 mt-lg-3 mt-md-3 mt-xl-3 mt-xxl-6">
                <div class="row align-items-center">
                    <div class="col-sm-12 d-none col-lg-6 mb-4 p-1 rounded d-sm-none d-md-none d-lg-block mt-4 mt-md-0" id="">
                        <h2 class="text-center text-light mb-2">Inicia sesión para comenzar</h2>
                        <img src="../img/registro1.png" class="rounded mx-auto d-block d-sm-none d-md-block" width="420" alt="...">
                        <div class="row mt-4">
                            <div class="d-grid gap-2 col-6 mx-auto mb-2">
                                <a id="" class="btn btn-primary text-center text-light rounded-pill" href="../Registrar/Registrar.php">Crea una cuenta</a>
                            </div>
                        </div>
                    </div>

                    <!-- Apartado Derecho -->
                    <div class="col-sm-12 col-lg-6 mt-4 p-3 rounded" id="barraNav">
                        <h1 class="text-center text-primary mt-3"><strong> Bienvenido </strong></h1>
                        <?php mostrarMensajes($errors) ?>

                        <form action="iniciarSesion.php" method="POST" class="row mt-5" autocomplete="off">

                        <input type="hidden" name="proceso" value="<?php echo $proceso;?>">
                            <div class="col-12 col-md-12 mb-3">
                                <label for="txtus" class="form-label">Nombre de usuario:</label>
                                <input type="text" placeholder="Introduce tu nombre de usuario" name="txtus" id="txtus" class="form-control">
                                <div class="invalid-feedback">Por favor introduce el nombre de usuario correctamente</div>
                            </div>

                            <div class="col-12 col-md-12 mb-3 mt-3 mb-4">
                                <label for="txtcon" class="form-label">Contraseña:</label>
                                <input type="password" placeholder="*******" name="txtcon" id="txtcon" class="form-control">
                                <div class="invalid-feedback">Tu contraseña debe la misma que la que ingresaste al registrarte</div>
                            </div>
                            <a class="text-primary mb-4" href="recuperar.php"> ¿Olvidaste tu contraseña?</a>
                            <div class="d-grid gap-2 col-6 mx-auto mb-4">

                                <input type="submit" class="btn btn-primary" value="Iniciar Sesión">
                                <div class="invalid-feedback"> Asegúrate de que todos los campos estén llenos</div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Pie de pagina -->
    <footer class="text-center text-primary fixed-bottom mt-5">
        <div class="text-center p-1 p-lg-3 p-sm-3 p-md-3 p-xl-3 p-xxl-3" id="barraNav">
            © 2022 Copyright:
            <a class="text-primary" href="#">Derechos reservados para Alejandro, Rogelio, Reyna</a>
        </div>
    </footer>
    <!-- Bootstrap Java -->
    <script src="../bootstrap5/js/bootstrap.bundle.js"></script>

</body>

</html>