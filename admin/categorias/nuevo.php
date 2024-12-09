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

?>

<main>
    <div class="container-fluid px-4"><br>
        <h1 class="text-light">Nueva categoria</h1>

        <form action="guarda.php" method="post" autocomplete="off">
            <div class="mb-3">
              <label for="nombre" class="form-label text-light">Nombre:</label>
              <input type="text" class="form-control" name="nombre" id="nombre" required autofocus>
            </div>

            <button type="submit" class="btn btn-primary btn-lg">Guardar <i class="fa-solid fa-floppy-disk"></i></button>
        </form>

    </div>
</main>
<?php

require '../footer.php';

?>