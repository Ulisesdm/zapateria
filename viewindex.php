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
              <li><a class="dropdown-item" href="#">Adidas</a></li>
              <li><a class="dropdown-item" href="#">Nike</a></li>
              <li><a class="dropdown-item" href="#">Skechers</a></li>
              <li><a class="dropdown-item" href="#">Vans</a></li>
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
  
  <main>
    <!-- Primer nivel -->
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-sm-12 col-lg-12">
          <h1 class="mt-5 text-light text-center">- - - - BIENVENIDO A ZAPATERÍA ADONAY - - - -</h1> <br>
          <div class="row justify-content-center">
            <div class="row">
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-sm-8 col-lg-11 mt-1">
                    <div id="carouselExampleControls" class="carousel slide" data-interval="corousel">
                      <div class="carousel-inner">
                        <div class="carousel-item active">
                          <img src="img/carrusel2.png" class="d-block w-100" alt="..." height="500">
                        </div>
                        <div class="carousel-item">
                          <img src="img/carrusel1.png" class="d-block w-100" alt="..." height="500">
                        </div>
                        <div class="carousel-item">
                          <img src="img/Publicidad57.jpg" class="d-block w-100" alt="..." height="500">
                        </div>
                        <div class="carousel-item">
                          <img src="img/vans2.png" class="d-block w-100" alt="..." height="500">
                        </div>
                      </div>
                      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div><br>
            <h5 class="text-center text-light col-lg-8 mt-3">Bienvenid@ al portal de la zapatería ADONAY. Aquí encontrarás los mejores zapatos
              o tenis para todos los géneros, elige entre Botas, Botines, Plataforma, Confort y mucho más...</h5><br>
          </div>
        </div>
      </div>
    </div><br>
  </main>

  <!-- Apartados tarjetas temas -->
  <div class="mt-2 ">
    <h1 class="text-center text-light">- - - Nueva colección de verano - - -</h1>
  </div>

  <div class="container">
    <div class="row align-items-center">
      <div class="row row-cols-1 row-cols-lg-3 g-3">

        <div class="col">
          <div class="card text-white bg-info mb-3">
            <img src="img/converse3.jpg" class="card-img-top w-35" alt="...">
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
            <img src="img/poster4.jpg" class="card-img-top w-35" alt="...">
            <div class="card-body">
              <h5 class="card-title">Prueba los nuevos Converse</h5>
              <p class="card-text">Ya disponible para su compra en Zapatería Adonay.</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div><br>

  <!-- ultimo nivel -->
  <div class="mt-2 ">
    <h1 class="text-center text-light">- - - - Precio, moda y calidad - - - -</h1>
  </div>

  <div class="container mt-5 col-sm-12 mb-4">
    <div class="row justify-content-center">
      <div class="col-sm-12 col-lg-5 my-auto">
        <h2 class=" text-center text-light">¡Vísitanos en nuestra tienda!</h2> <br>
        <p class="text-center text-light">Si has comprado en línea puedes venir a la tienda de 9:00 AM a 18:00 PM a recoger tu pedido.<br>
      </div>
      <div class="col-sm-12 col-lg-5">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d874.5150953206266!2d-100.14193441719367!3d18.89246779516309!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85cd133bfc606663%3A0x842ac8322094fc34!2sMi%20Bodega%20Aurrera%2C%20Tejupilco%20Cristobal!5e1!3m2!1ses-419!2smx!4v1690236889316!5m2!1ses-419!2smx" width="600" height="330" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><br><br>



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