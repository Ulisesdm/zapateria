<?php
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'clases/clienteFunciones.php';

$user_id = $_GET['id'] ?? $_POST['user_id'] ?? '';
$token = $_GET['token'] ?? $_POST['token'] ?? '';

if ($user_id == '' || $token == '') {
  header("Location: index.php");
  exit;
}

$db = new Database();
$con = $db->conectar();

$errors = [];

if (!verificarTokenRequest($user_id, $token, $con)) {
  header("Location: index.php");
  exit;
}

if (!empty($_POST)) {

  $password = trim($_POST['password']);
  $repassword = trim($_POST['repassword']);

  if (esNulo([$user_id, $token, $password, $repassword])) {
    $errors[] = "Debe llenar todos los campos";
  }

  if (!validaPassword($password, $repassword)) {
    $errors[] = "Las contraseñas no coinciden";
  }

  if (count($errors) == 0) {
    $pass_hash = password_hash($password, PASSWORD_DEFAULT);
    if (actualizarPassword($user_id, $pass_hash, $con)) {
      header("Location: iniciar_sesion/iniciarSesion.php");
      exit;
    } else {
      $errors[] = "Error al modificar contraseña";
    }
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
    <link rel="stylesheet" href="css/estilos-glass.css">
    <link href="bootstrap5/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap5/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos-glass.css">
    <link href="fontawesome/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
      <div class="container mt-3 mt-lg-3 mt-md-3 mt-xl-3 mt-xxl-6">
        <div class="row align-items-center">
          <div class="col-sm-12 d-none col-lg-6 mb-4 p-1 rounded d-sm-none d-md-none d-lg-block mt-4 mt-md-0" id="">

            <h2 class="text-center text-light">¡Casi terminamos, estás a un paso!</h2>
            <img src="img/icecream.png" class="rounded mx-auto d-block d-sm-none d-md-block" width="410" alt="...">
          </div>

          <!-- Apartado Derecho -->
          <div class="col-sm-12 col-lg-6 mt-4 p-3 rounded" id="barraNav">
            <h1 class="text-center text-primary mt-3"><strong> Nueva contraseña </strong></h1>
            <?php mostrarMensajes($errors) ?>

            <form action="reset_password.php" method="POST" class="row mt-5" autocomplete="off">

              <input type="hidden" name="user_id" id="user_id" value="<?= $user_id; ?>" />
              <input type="hidden" name="token" id="token" value="<?= $token; ?>" />

              <div class="col-12 col-md-12 mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" placeholder="Introduce una nueva contraseña para iniciar sesión" name="password" id="password" class="form-control" required>
              </div>

              <div class="col-12 col-md-12 mb-3">
                <label for="repassword" class="form-label">Confirmar contraseña:</label>
                <input type="password" placeholder="Confirma la nueva contraseña" name="repassword" id="repassword" class="form-control" required>
              </div>

              <a class="text-primary mb-4 center" href="iniciar_sesion/iniciarSesion.php"> ¿Ya tienes una cuenta? Inicia sesión</a>
              <div class="d-grid gap-2 col-6 mx-auto mb-4">

                <input type="submit" class="btn btn-primary" value="Continuar">
                <div class="invalid-feedback"> Asegúrate de que todos los campos estén llenos</div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <div class="mb-5" id="burbujas">
    <div id="burbuja"></div>
    <div id="burbuja"></div>
    <div id="burbuja"></div>
    <div id="burbuja"></div>
    <div id="burbuja"></div>
    <div id="burbuja"></div>
  </div>

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