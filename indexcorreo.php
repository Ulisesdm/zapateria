<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="bootstrap5/css/bootstrap.min.css" rel="stylesheet">
  <!-- ESTILOS PERSONALIZADOS CSS -->
  <link rel="shortcut icon" href="img/kanye.ico">
  <link rel="stylesheet" href="iniciar_sesion/estilos-carga-inicio.css">
  <link rel="stylesheet" href="css/estilos-glass.css">
  <link href="bootstrap5/css/bootstrap.css" rel="stylesheet">
  <!-- JS AJAX -->
  <script src="js/jquery-3.5.1/jquery.min.js"></script>
  <!-- CSS Y JS SWEET ALERT 2 -->
  <script src="js/sweetalert2@11/sweetalert2.js"></script>

  <title>Zapatería Adonay</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body id="bod">


  <!-- Barra de navegacion -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="barraNav">
    <div class="container-fluid">
      <img src="img/logo2.png" alt="" width="55" height="40" class="d-inline-block align-text-top">
      <a class="navbar-brand" href="#">Zapatería Adonay</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active mx-2" aria-current="page" href="carrito/catalogo.php">Ver todos los productos</a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Ver por categorías
            </a>
            <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarDarkDropdownMenuLink">
             <li><a class="dropdown-item" href="carrito/catalogoadidas.php">Adidas</a></li>
              <li><a class="dropdown-item" href="carrito/catalogonike.php">Nike</a></li>
              <li><a class="dropdown-item" href="carrito/catalogoskechers.php">Skechers</a></li>
              <li><a class="dropdown-item" href="carrito/catalogovans.php">Vans</a></li>
            </ul>

          <li class="nav-item">
            <a class="nav-link mx-2 active" aria-current="page" href="carritonuevo/nuevoCarrito.php">Quiénes sómos</a>
          </li>
        </ul>
      </div>
      <div class="d-flex d-sm-none d-lg-block">
        <a class="btn btn-outline-primary mx-3" href="iniciar_sesion/iniciarSesion.php">Iniciar Sesión</a>
      </div>
      <div class="d-flex d-sm-none d-lg-block">
        <a class="btn btn-outline-primary mx-3" href="Registrar/Registrar.php">Regístrate</a>
      </div>
    </div>
    </div>
  </nav>

  <!-- Primer nivel -->
  <div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-sm-12 col-lg-8"> <!-- Adjust the column size to control the width of the card -->
      <h1 class="mt-5 text-light text-center">- - - - TE HEMOS ENVIADO UN CORREO - - - -</h1> <br>
      <div class="row justify-content-center">
        <div class="col-sm-12 col-lg-8 mt-3"> <!-- Adjust the column size to control the width of the card -->
          <div class="card">
            <img src="img/email.gif" alt="..." height="300" class="card-img-top mx-auto d-block img-fluid">
            <div class="card-body">
              <p class="text-center text-primary">Revisa tu bandeja de entrada para restablecer tu contraseña (Si no ves nada puedes revisar en la carpeta 'Spam').</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><br>




  <!-- Apartados tarjetas temas -->
  <div class="mt-2 ">
    <h1 class="text-center text-light">- - - Nueva colección de verano - - -</h1>
  </div>

  <div class="container">
    <div class="row align-items-center">
      <div class="row row-cols-1 row-cols-lg-3 g-3">

        <div class="col">
          <div class="card text-white bg-info mb-3">
            <img src="img/poster2.jpg" class="card-img-top w-35" alt="...">
            <div class="card-body">
              <h5 class="card-title">Summer Heat Pack</h5>
              <p class="card-text">Prueba el último conjunto de verano.</p>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card text-white bg-danger mb-3">
            <img src="img/poster1.jpg" class="card-img-top w-35" alt="...">
            <div class="card-body">
              <h5 class="card-title">Nuevos productos en stock</h5>
              <p class="card-text">Prueba el último conjunto de verano.</p>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card text-white bg-success mb-3">
            <img src="img/poster5.jpg" class="card-img-top w-35" alt="...">
            <div class="card-body">
              <h5 class="card-title">Prueba los nuevos Converse</h5>
              <p class="card-text">Ya disponible para su compra en Zapatería Adonay.</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div><br>

  <!-- Pie de pagina -->
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

  <script src="jquery/jquery-3.5.1.min.js"></script>
  <script src="bootstrap5/js/bootstrap.bundle.js"></script>
  <script src="js/datatables.min.js"></script>
  <script src="js/funciones.js"></script>

</body>

</html>