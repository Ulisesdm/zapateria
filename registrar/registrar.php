<?php
require '../config/config.php';
require '../clases/clienteFunciones.php';

$db = new Database();
$con = $db->conectar();

$errors = [];

if (!empty($_POST)) {

  $nombres = trim($_POST['txtnom']);
  $apellidos = trim($_POST['txtape']);
  $email = trim($_POST['txtcor']);
  $telefono = trim($_POST['txttel']);
  $usuario = trim($_POST['txtus']);
  $password = trim($_POST['txtcon']);
  $repassword = trim($_POST['txtrecon']);

  if (esNulo([$nombres, $apellidos, $email, $telefono, $usuario, $password, $repassword])) {
    $errors[] = "Debe llenar todos los campos";
  }

  if (!esEmail($email)) {
    $errors[] = "La direccion no es válida";
  }

  if (!validaPassword($password, $repassword)) {
    $errors[] = "Las contraseñas no coinciden";
  }

  if (usuarioExiste($usuario, $con)) {
    $errors[] = "El nombre de usuario $usuario ya existe";
  }

  if (emailExiste($email, $con)) {
    $errors[] = "El  correo $email ya existe";
  }

  if (count($errors) == 0) {

    $id = registrarCliente([$nombres, $apellidos, $email, $telefono], $con);

    if ($id > 0) {

      require  '../clases/mailer.php';
      $mailer = new Mailer();
      $token = generarToken();
      $pass_hash = password_hash($password, PASSWORD_DEFAULT);
      $idusuario = registrarUsuario([$usuario, $pass_hash, $token, $id], $con);
      if ($idusuario > 0) {

        $url = SITE_URL . '/activar_cliente.php?id=' . $idusuario . '&token=' . $token;

        //http://localhost/html5/Adonay/activa_cliente.php?idusuario=1&token=3cb373fff21541327045fd5c564b0d5b

        $asunto = "Activar cuenta para continuar - Zapateria Adonay";
        $cuerpo = "Estimado $nombres: <br> Para continuar con el proceso de registro, es necesario hacer click al siguiente link <a href='$url'>Activar cuenta</a>";


        if ($mailer->enviarEmail($email, $asunto, $cuerpo)) {
            header("Location: ../indexcorreoregistro.php");
          exit;
        }
      } else {
        $errors[] = "Error al registrar el usuario";
      }
    } else {
      $errors[] = "Error al registrar el cliente";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

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
     <?php include '../navegacion.php'; ?>


  <main>
    <div class="container">
      <div class="container mt-2 mt-lg-3 mt-md-3 mt-xl-3 mt-xxl-7">
        <div class="row align-items-center">
          <div class="col-sm-12 d-none col-lg-6 mb-1 p-1 rounded d-sm-none d-md-none d-lg-block mt-4 mt-md-0" id="">
            <br>
            <h2 class="text-center text-light mb-1">Bienvenido a Zapatería ADONAY</h2>
            <img src="../img/registro1.png" class="rounded mx-auto d-block d-sm-none d-md-block" width="400" alt="...">
            <h2 class="text-center text-light mb-1">Precio, moda y calidad</h2>
          </div>

          <!-- Apartado Derecho -->
          <div class="col-sm-12 col-lg-6 p-4 rounded mt-md-2" id="barraNav">
            <h1 class="text-center text-primary mt-1"><strong>Create una cuenta</strong></h1>

            <?php mostrarMensajes($errors); ?>

            <form action="registrar.php" id="frmRegistro" method="post" class="row mt-4">

              <div class="col-12 col-md-12 mb-3">
                <label for="txtcor" class="form-label">Correo electronico:</label>
                <input type="email" placeholder="alguien@example.com" name="txtcor" id="txtcor" class="form-control">
                <div class="invalid-feedback">Por favor introduce tu correo con formato alguien@ejemplo.com para continuar.</div>
                <span id="validaEmail" class="text-danger"></span>

              </div>

              <div class="col-12 col-md-6 mb-3">
                <label for="txtus" class="form-label">Nombre de usuario:</label>
                <input type="text" placeholder="Escribe aquí tu nombre de usuario" name="txtus" id="txtus" class="form-control ">
                <div class="invalid-feedback">Por favor introduce tu nombre de usuario.</div>
                <span id="validaUsuario" class="text-danger"></span>
              </div>

              <div class="col-12 col-md-6 mb-3">
                <label for="txtnom" class="form-label">Nombre personal:</label>
                <input type="text" placeholder="Escribe aquí tu nombre real" name="txtnom" id="txtnom" class="form-control ">
                <div class="invalid-feedback">Por favor introduce al menos 4 carácteres.</div>
              </div>

              <div class="col-12 col-md-6 mb-3">
                <label for="txtape" class="form-label">Apellido:</label>
                <input type="text" placeholder="Escribe aquí tu apellido" name="txtape" id="txtape" class="form-control ">
                <div class="invalid-feedback">Por favor introduce al menos 4 carácteres.</div>
              </div>

              <div class="col-12 col-md-6 mb-3">
                <label for="txttel" class="form-label">Teléfono:</label>
                <input type="tel" placeholder="Ingresa aquí tu número de teléfono" name="txttel" id="txttel" class="form-control ">
              </div>

              <div class="col-12 col-md-6 mb-3 ">
                <label for="txtcon" class="form-label ">Crea una contraseña:</label>
                <input type="password" placeholder="*******" name="txtcon" id="txtcon" class="form-control">
                <div class="invalid-feedback">Tu contraseña debe tener al menos 8 caracteres con Mayúsculas, Minúsculas, Números y Caracteres Especiales.</div>
              </div>

              <div class="col-12 col-md-6 mb-3 ">
                <label for="txtrecon" class="form-label ">Repite la contraseña:</label>
                <input type="password" placeholder="*******" name="txtrecon" id="txtrecon" class="form-control">
                <div class="invalid-feedback">Tu contraseña debe coincidir</div>
              </div>

              <div class="d-grid gap-2 col-6 mx-auto mb-1">
                <input type="submit" id="btnGuaAut" class="btn btn-primary" value="Registrar">
                <div class="invalid-feedback">Asegúrate de que todos los campos estén llenos</div>
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
  </div>

  <!-- Pie de pagina -->
  <footer class="text-center text-primary fixed-bottom mt-5">
    <div class="text-center p-1 p-lg-3 p-sm-3 p-md-3 p-xl-3 p-xxl-3" id="barraNav">
      © 2023 Copyright:
      <a class="text-primary" href="#">Derechos reservados para Alejandro, Rogelio, Reyna y Gael</a>
    </div>
  </footer>
  <!-- Bootstrap Java -->
  <script src="../bootstrap5/js/bootstrap.bundle.js"></script>

  <script>
    let txtUsuario = document.getElementById('txtus')
    txtUsuario.addEventListener("blur", function() {
      existeUsuario(txtUsuario.value)
    }, false)

    let txtEmail = document.getElementById('txtcor')
    txtEmail.addEventListener("blur", function() {
      existeEmail(txtEmail.value)
    }, false)

    function existeEmail(email) {
      let url = "../clases/clienteAjax.php"
      let formData = new FormData()
      formData.append("action", "existeEmail")
      formData.append("txtcor", email)

      fetch(url, {
          method: 'POST',
          body: formData
        }).then(response => response.json())
        .then(data => {

          if (data.ok) {
            document.getElementById('txtcor').value = ''
            document.getElementById('validaEmail').innerHTML = 'El correo electrónico no está disponible'
          } else {
            document.getElementById('validaEmail').innerHTML = ''
          }

        })
    }

    function existeUsuario(usuario) {

      let url = "../clases/clienteAjax.php"
      let formData = new FormData()
      formData.append("action", "existeUsuario")
      formData.append("txtus", usuario)

      fetch(url, {
          method: 'POST',
          body: formData
        }).then(response => response.json())
        .then(data => {

          if (data.ok) {
            document.getElementById('txtus').value = ''
            document.getElementById('validaUsuario').innerHTML = 'Usuario no disponible'
          } else {
            document.getElementById('validaUsuario').innerHTML = ''
          }

        })
    }
  </script>

</body>

</html>