<?php

require '../config/database.php';
require '../config/config.php';


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

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$descuento = $_POST['descuentos'];
$stock = $_POST['stock'];
$categoria = $_POST['categoria'];

$sql="UPDATE tablaproductos SET nombre=?, descripcion=?, precio=?, descuentos=?, stock=?, idCategoria=? WHERE idProductos = ?";

$stm = $con->prepare($sql);

if($stm->execute([$nombre, $descripcion, $precio, $descuento, $stock, $categoria, $id])){
    
    //Subir imagen principal
    if($_FILES['imagen_principal']['error'] == UPLOAD_ERR_OK){
        $dir = '../../productos/' . $id . '/';
        $permitidos = ['jpeg', 'jpg'];
        $arregloImagen = explode('.', $_FILES['imagen_principal']['name']);
        $extension = strtolower(end($arregloImagen));

        if(in_array($extension, $permitidos)){
            if(!file_exists($dir)){
                mkdir($dir, 0777, true);
            }
            $ruta_img = $dir . 'principal.' . $extension;
            if(move_uploaded_file($_FILES['imagen_principal']['tmp_name'], $ruta_img)){
                echo "El archivo se ha cargado correctamente.";
            } else{
                echo "Error al cargar al archivo.";
            }
        } else{
            echo "Archivo no permitido";
        }
    } else{
        echo "No enviaste un archivo";
    }

    //subir otras imagenes
    if(isset($_FILES['otras_imagenes'])){
        $dir = '../../productos/' . $id . '/';
        $permitidos = ['jpeg', 'jpg'];

        if(!file_exists($dir)){
            mkdir($dir, 0777, true);
        }
        
        foreach($_FILES['otras_imagenes']['tmp_name'] as $key => $tmp_name){
            $fileName = $_FILES['otras_imagenes']['name'][$key];
            
            $arregloImagen = explode('.', $fileName);
            $extension = strtolower(end($arregloImagen));

            $nuevoNombre = $dir . uniqid(). '.' . $extension;

            if (in_array($extension, $permitidos)){
                if(move_uploaded_file($tmp_name, $nuevoNombre)){
                    echo "El archivo se ha cargado correctamente.<br>";
                    $contador++;
                } else{
                    echo "Error al cargar al archivo.";
                }
            } else {
                echo "Archivo no permitido";
            }
            
        }
    }
    $idVariante = $_POST['id_variante'] ?? [];
    $talla = $_POST['talla'] ?? [];
    $color = $_POST['color'] ?? [];
    $precioVariante = $_POST['precio_variante'] ?? [];
    $stockVariante = $_POST['stock_variante'] ?? [];
    $sizeTalla = count($talla);

    if($sizeTalla == count($color) && $sizeTalla == count($precioVariante) && $sizeTalla == count($stockVariante))
    {
        $sql ="INSERT INTO productos_variantes (id_producto, id_talla, id_color, precio, stock)
        VALUES (?, ?, ? , ?, ?)";
        $stm = $con->prepare($sql);

        $sqlUpdate ="UPDATE productos_variantes SET id_talla = ?, id_color = ?, precio = ?, stock = ? WHERE idvariantes = ?";
        $stmUpdate = $con->prepare($sqlUpdate);

        for($i = 0; $i < $sizeTalla; $i++){
            $idTalla = (int)$talla[$i]; //parseo para que funcione
            $idColor = (int)$color[$i];
            $stock = $stockVariante[$i];
            $precio = $precioVariante[$i];
            if(isset($idVariante[$i])){
                $stmUpdate->execute([$idTalla, $idColor, $precio, $stock, $idVariante[$i]]);
            } else{
                $stm->execute([$id, $idTalla, $idColor, $precio, $stock]);
            }
        }
    }
}

header('Location: index.php');

?>