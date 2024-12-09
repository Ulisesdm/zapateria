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

$sql = $con->prepare("SELECT idcategoria, nombre FROM categorias WHERE idcategoria = ? LIMIT 1");
$sql->execute([$id]);
$categoria = $sql->fetch(PDO::FETCH_ASSOC);

?>

<main>
    <div class="container-fluid px-4"><br>
        <h1 class="text-light">Editar Categoria</h1>

        <form action="actualiza.php" method="post" autocomplete="off">
            <input type="hidden" name="id" value="<?php echo $categoria['idcategoria']; ?>">
            <div class="mb-3">
              <label for="nombre" class="form-label text-light">Nombre:</label>
              <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $categoria['nombre']; ?>" required autofocus>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>

    </div>
</main>
<?php

require '../footer.php';

?>