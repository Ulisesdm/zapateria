<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - Admin Adonay</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="<?php echo ADMIN_URL; ?>css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>css/estilos-glass.css">
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>css/bootstrap.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="../fontawesome/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</head>

<body class="sb-nav-fixed" id="bod">
    <nav class="sb-topnav navbar navbar-expand" id="barraNav">
        <!-- Navbar Brand-->
        <img src="<?php echo ADMIN_URL; ?>images/logo2.png" alt="" width="55" height="40" class="d-inline-block align-text-top">
        <a class="navbar-brand ps-1" href="<?php echo ADMIN_URL;?>inicio.php">Administración Adonay</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Más opciones... <i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?php echo ADMIN_URL; ?>cerrar.php">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
        </form>
        <!-- Navbar-->
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading text-light">Core - Adonay</div>
                        <a class="nav-link text-light" href="<?php echo ADMIN_URL;?>configuracion">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Configuracion
                        </a>

                        <a class="nav-link text-light" href="<?php echo ADMIN_URL;?>categorias">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Categorías
                        </a>

                        <a class="nav-link text-light" href="<?php echo ADMIN_URL;?>productos">
                            <div class="sb-nav-link-icon"><i class="fas fa-shoe-prints"></i></div>
                            Productos
                        </a>

                        <a class="nav-link text-light" href="<?php echo ADMIN_URL;?>historial">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-check"></i></div>
                            Historial
                        </a>

                        <div class="sb-sidenav-menu-heading text-light">Interfaz</div>
                        <a class="nav-link collapsed text-light" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Usuarios
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo ADMIN_URL;?>usuarios">Administrar usuarios</a>
                            </nav>
                        </div>

                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Usuario:</div>
                    <a class="text-light"><?php echo $_SESSION['user_name']; ?></a>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">