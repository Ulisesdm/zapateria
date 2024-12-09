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

<main>
    <div class="container-fluid px-4"><br>
        <h1 class="text-light">Usuarios registrados</h1>


        <div class="table-responsive">
            <table class="table table-secondary">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Registro:</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($usuarios as $usuario){ ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['nombres'], ENT_QUOTES); ?></td>
                            <td><?php echo $usuario['email']; ?></td>
                            <td><?php echo $usuario['telefono']; ?></td>
                            <td><?php echo $usuario['fechaalta']; ?></td>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</main>

<!-- Modal trigger button -->


<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="modalElimina" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Confirmar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Desea eliminar el registro?
            </div>
            <div class="modal-footer">
                <form action="elimina.php" method="post">
                    <input type="hidden" name="id">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
            </div>
        </div>
    </div>
</div>


<!-- Optional: Place to the bottom of scripts -->
<script>
    let eliminaModal = document.getElementById('modalElimina')
    eliminaModal.addEventListener('show.bs.modal', function(event){
        let button = event.relatedTarget
        let id = button.getAttribute('data-bs-id')

        let modalInput = eliminaModal.querySelector('.modal-footer input')
        modalInput.value = id
    })
</script>
<?php

require '../footer.php';

?>