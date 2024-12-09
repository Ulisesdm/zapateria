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


$sql = "SELECT idclientes, nombres, email, telefono, fechaalta FROM tablaclientes WHERE status = 1";
$resultado = $con->query($sql);
$usuarios = $resultado->fetchAll(PDO::FETCH_ASSOC);


?>

<style>
    .ck-editor__editable[role="textbox"]{
        min-height: 80px;
    }
</style>
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

<main>
    <div class="container-fluid px-4"><br>
        <h1 class="text-light">Nuevo producto</h1>

        <form action="guarda.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="mb-3">
                <label for="nombre" class="form-label text-light">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" required autofocus>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label text-light">Descripción:</label>
                <textarea class="form-control" name="descripcion" id="editor"></textarea>
            </div>

            <div class="row mb-2">
                <div class="col">
                    <label for="imagen_principal" class="form-label text-light">Imágen Principal</label>
                    <input type="file" class="form-control" name="imagen_principal" id="imagen_principal" accept="image/jpeg" required>
                </div>
                <div class="col">
                    <label for="otras_imagenes" class="form-label text-light">Imágen Secundaria</label>
                    <input type="file" class="form-control" name="otras_imagenes[]" id="otras_imagenes" accept="image/jpeg" multiple>
                </div>

            </div>

            <div class="row">
                <div class="col mb-3">
                    <label for="precio" class="form-label text-light">Precio:</label>
                    <input type="number" class="form-control" name="precio" id="precio" required>
                </div>

                <div class="col mb-3">
                    <label for="descuentos" class="form-label text-light">Descuento:</label>
                    <input type="number" class="form-control" name="descuentos" id="descuentos" required>
                </div>

                <div class="col mb-3">
                    <label for="stock" class="form-label text-light">Stock:</label>
                    <input type="number" class="form-control" name="stock" id="stock" required>
                </div>
            </div>

            <div class="row">
                <div class="col-4 mb-3">
                    <label for="categoria" class="form-label text-light">Categoria:</label>
                    <select class="form-select" name="categoria" id="categoria" required>
                        <option value="">Seleccionar</option>
                        <?php foreach ($categorias as $categoria) { ?>
                            <option value="<?php echo $categoria['idcategoria']; ?>"><?php echo $categoria['nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>

    </div>
</main>

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

<?php require '../footer.php'; ?>