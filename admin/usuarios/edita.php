<?php
require '../config/database.php';
require '../config/config.php';
require '../header.php';

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

$id = $_GET['id'];

$sql = $con->prepare("SELECT idusuario, usuario, password, activacion, id_cliente FROM datos_usuarios WHERE idusuario = ? AND activacion = 1");
$sql->execute([$id]);
$producto = $sql->fetch(PDO::FETCH_ASSOC);

?>

<main>
    <div class="container-fluid px-4"><br>
        <h1 class="text-light">Modificar usuario</h1>

        <form action="actualiza.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <input type="hidden" name="id" value="<?php echo $producto['idusuario'] ?>">
            <div class="mb-3">
                <label for="usuario" class="form-label text-light">Nombre de usuario:</label>
                <input type="text" class="form-control" name="usuario" id="usuario" value="<?php echo $producto['usuario'] ?>" required autofocus>
            </div>

            <div class="row mb-2">
                <div class="col">
                    <label for="password" class="form-label text-light">Contraseña:</label>
                    <input type="password" class="form-control" name="password" id="password" value="<?php echo $producto['password'] ?>" required autofocus>
                </div>
            </div><br>

            <button type="submit" class="btn btn-primary btn-lg">Guardar <i class="fa-solid fa-floppy-disk"></i></button>
        </form><br>

    </div>
</main>

<?php require '../footer.php'; ?>