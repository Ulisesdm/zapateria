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

$sql = $con->prepare("SELECT idProductos, nombre, descripcion, precio, stock, descuentos, idCategoria FROM tablaproductos WHERE idProductos = ? AND activo = 1");
$sql->execute([$id]);
$producto = $sql->fetch(PDO::FETCH_ASSOC);


$sql = "SELECT idcategoria, nombre FROM categorias WHERE activo=1";
$resultado = $con->query($sql);
$categorias = $resultado->fetchAll(PDO::FETCH_ASSOC);

$rutaImagenes = '../../productos/' . $id . '/';
$imagenPrincipal = $rutaImagenes . 'principal.jpg';
$imagenes = [];
$dirInit = dir($rutaImagenes);

while (($archivo = $dirInit->read()) !== false) {
    if ($archivo != 'principal.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))) {
        $image = $rutaImagenes . $archivo;
        $imagenes[] = $image;
    }
}

$dirInit->close();


$resultado = $con->query("SELECT idtallas, nombre FROM c_tallas");
$tallas = $resultado->fetchAll(PDO::FETCH_ASSOC);

$resultado = $con->query("SELECT idcolores, nombre FROM c_colores");
$colores = $resultado->fetchAll(PDO::FETCH_ASSOC);

$sqlVariantes = $con->prepare("SELECT idvariantes, id_talla, id_color, precio, stock FROM productos_variantes WHERE id_producto = ?");
$sqlVariantes->execute([$id]);
$variantes = $sqlVariantes->fetchAll(PDO::FETCH_ASSOC);


?>

<style>
    .ck-editor__editable[role="textbox"] {
        min-height: 80px;
    }
</style>

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

<main>
    <div class="container-fluid px-4"><br>
        <h1 class="text-light">Modificar producto</h1>

        <form action="actualiza.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <input type="hidden" name="id" value="<?php echo $producto['idProductos'] ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label text-light">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $producto['nombre'] ?>" required autofocus>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label text-light">Descripción:</label>
                <textarea class="form-control" name="descripcion" id="editor"><?php echo $producto['descripcion']; ?></textarea>
            </div>


            <div class="row mb-2">
                <div class="col">
                    <label for="imagen_principal" class="form-label text-light">Imágen Principal</label>
                    <input type="file" class="form-control" name="imagen_principal" id="imagen_principal" accept="image/jpeg">
                </div>
                <div class="col">
                    <label for="otras_imagenes" class="form-label text-light">Imágen Secundaria</label>
                    <input type="file" class="form-control" name="otras_imagenes[]" id="otras_imagenes" accept="image/jpeg" multiple>
                </div>

            </div>

            <div class="row mb-2">
                <div class="col-12 col-md-6">
                    <?php if (file_exists($imagenPrincipal)) { ?>
                        <div class="position-relative">
                            <img src="<?php echo $imagenPrincipal; ?>" class="img-thumbnail my-3" style="max-width: 100%;">
                            <button class="btn btn-danger btn-lg position-absolute top-0 start-0" onclick="eliminarImagen('<?php echo $imagenPrincipal; ?>')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    <?php } ?>
                </div>

                <div class="col-12 col-md-6">
                    <div class="row">
                        <?php foreach ($imagenes as $imagen) { ?>
                            <div class="col-4 position-relative">
                                <img src="<?php echo $imagen; ?>" class="img-thumbnail my-3" style="max-width: 100%;">
                                <button class="btn btn-danger btn-sm position-absolute top-0 start-0" onclick="eliminarImagen('<?php echo $imagen; ?>')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label for="precio" class="form-label text-light">Precio:</label>
                    <input type="number" class="form-control" name="precio" id="precio" value="<?php echo $producto['precio'] ?>" required>
                </div>

                <div class="col mb-3">
                    <label for="descuentos" class="form-label text-light">Descuento:</label>
                    <input type="number" class="form-control" name="descuentos" id="descuentos" value="<?php echo $producto['descuentos'] ?>" required>
                </div>

                <div class="col mb-3">
                    <label for="stock" class="form-label text-light">Stock:</label>
                    <input type="number" class="form-control" name="stock" id="stock" value="<?php echo $producto['stock'] ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-4 mb-3">
                    <label for="categoria" class="form-label text-light">Categoria:</label>
                    <select class="form-select" name="categoria" id="categoria" required>
                        <?php foreach ($categorias as $categoria) { ?>
                            <option value="<?php echo $categoria['idcategoria']; ?>" <?php if ($categoria['idcategoria'] == $producto['idCategoria']) { echo 'selected';} ?>><?php echo $categoria['nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-4 mb-3">
                    <h3 class="me-4 text-white">Variantes</h3>
                    <button type="button" class="btn btn-success btn-lg" id="agrega-variante">+ Variante</button>
                </div>
            </div>

            <div id="contenido">
                <?php foreach($variantes as  $variante) {?>
                    <div class="row mb-3">
                    <input type="hidden" name="id_variante[]" value="<?php echo $variante['idvariantes']; ?>">
                    <div class="col">
                            <label class="form-label text-white">Talla:</label>
                            <select class="form-select" name="talla[]">
                                <option value="">Seleccionar</option>
                                <?php foreach ($tallas as $talla) { ?>
                            <option value="<?php echo $talla['idtallas']; ?>" <?php if ($talla['idtallas'] ==
                            $variante['id_talla']) { echo 'selected';} ?>><?php echo $talla['nombre']; ?></option>
                        <?php } ?>
                            </select>
                    </div>
                    
                    <div class="col">
                            <label class="form-label text-white">Color:</label>
                            <select class="form-select" name="color[]">
                                <option value="">Seleccionar</option>
                                <?php foreach ($colores as $color) { ?>
                            <option value="<?php echo $color['idcolores']; ?>" <?php if ($color['idcolores'] ==
                            $variante['id_color']) { echo 'selected';} ?>><?php echo $color['nombre']; ?></option>
                        <?php } ?>
                            </select>
                    </div>

                    <div class="col">
                            <label class="form-label text-white">Precio:</label>
                            <input type="text" class="form-control" name="precio_variante[]" value="<?php echo $variante['precio']; ?>">
                    </div>

                    <div class="col">
                            <label class="form-label text-white">Stock:</label>
                            <input type="text" class="form-control" name="stock_variante[]" value="<?php echo $variante['stock']; ?>">
                    </div>

                </div>
                    <?php } ?>
            </div>

            <template id="plantilla_variante">
                <div class="row mb-3">
                    <div class="col">
                            <label class="form-label">Talla:</label>
                            <select class="form-select" name="talla[]">
                                <option value="">Seleccionar</option>
                                <?php foreach ($tallas as $talla) { ?>
                            <option value="<?php echo $talla['idtallas']; ?>"><?php echo $talla['nombre']; ?></option>
                                <?php } ?>
                            </select>
                    </div>
                    
                    <div class="col">
                            <label class="form-label">Color:</label>
                            <select class="form-select" name="color[]">
                                <option value="">Seleccionar</option>
                                <?php foreach ($colores as $color) { ?>
                            <option value="<?php echo $color['idcolores']; ?>"><?php echo $color['nombre']; ?></option>
                                <?php } ?>
                            </select>
                    </div>

                    <div class="col">
                            <label class="form-label">Precio:</label>
                            <input type="text" class="form-control" name="precio_variante[]">
                    </div>

                    <div class="col">
                            <label class="form-label">Stock:</label>
                            <input type="text" class="form-control" name="stock_variante[]">
                    </div>

                </div>
            </template>
            <button type="submit" class="btn btn-primary btn-lg">Guardar <i class="fa-solid fa-floppy-disk"></i></button>
        </form><br>

    </div>
</main>

<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });

    function eliminarImagen(urlImagen) {
        let url = 'eliminar_imagen.php'
        let formData = new FormData()
        formData.append('urlImagen', urlImagen)

        fetch(url, {
            method: 'POST',
            body: formData
        }).then((response) => {
            if (response.ok) {
                location.reload()
            }
        })
    }

    const btnVariante = document.getElementById('agrega-variante')
    btnVariante.addEventListener('click', agregaVariante);

    function agregaVariante(){
        const contenido = document.getElementById('contenido')
        const plantilla = document.getElementById('plantilla_variante').content.cloneNode(true)

        contenido.appendChild(plantilla)

    }
</script>


<?php require '../footer.php'; ?>