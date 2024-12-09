<?php

function esNulo(array $parametros)
{
    foreach ($parametros as $parametro) {
        if (strlen(trim($parametro)) < 1) {
            return true;
        }
    }
}

function esEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

function validaPassword($password, $repassword)
{
    if (strcmp($password, $repassword) === 0) {
        return true;
    }
    return false;
}

function generarToken()
{
    return md5(uniqid(mt_rand(), false));
}

function registrarCliente(array $datos, $con)
{
    $sql = $con->prepare("INSERT INTO tablaclientes (nombres, apellidos, email, telefono, status, fechaalta) VALUES (?,?,?,?, 1, NOW())");
    if ($sql->execute($datos)) {
        return $con->lastInsertId();
    }
    return 0;
}

function registrarUsuario(array $datos, $con)
{
    $sql = $con->prepare("INSERT INTO datos_usuarios (usuario, password, token, id_cliente) VALUES (?,?,?,?)");
    if ($sql->execute($datos)) {
        return $con->lastInsertId();
    }
    return 0;
}

function usuarioExiste($usuario, $con)
{
    $sql = $con->prepare("SELECT idusuario FROM datos_usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    if ($sql->fetchColumn() > 0) {
        return true;
    }
    return false;
}

function emailExiste($email, $con)
{
    $sql = $con->prepare("SELECT idclientes FROM tablaclientes WHERE email LIKE ? LIMIT 1");
    $sql->execute([$email]);
    if ($sql->fetchColumn() > 0) {
        return true;
    }
    return false;
}

function mostrarMensajes(array $errors)
{
    if (count($errors) > 0) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul>';
        foreach ($errors as $error) {
            echo  '<li>' . $error . '</li>';
        }
        echo '<ul>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
}

function validaToken($id, $token, $con)
{
    $msg = "";
    $sql = $con->prepare("SELECT idusuario FROM datos_usuarios WHERE idusuario = ? AND token LIKE ? LIMIT 1");
    $sql->execute([$id, $token]);
    if ($sql->fetchColumn() > 0) {
        if (activarUsuario($id, $con)) {
            header("Location: ./iniciar_sesion/iniciarSesion.php");
        } else {
            $msg = "Error al activar cuenta";
        }
    } else {
        $msg = "No existe el registro del cliente";
    }
    return $msg;
}

function activarUsuario($id, $con)
{
    $sql = $con->prepare("UPDATE datos_usuarios SET activacion = 1, token = '' WHERE idusuario = ?");
    return $sql->execute([$id]);
}

function login($usuario, $password, $con, $proceso)
{
    $sql = $con->prepare("SELECT idusuario, usuario, id_cliente, password FROM datos_usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if (esActivo($usuario, $con)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['idusuario'];
                $_SESSION['user_name'] = $row['usuario'];
                $_SESSION['user_cliente'] = $row['id_cliente'];
                if ($proceso == 'pago') {
                    header("Location: ../carrito/checkout.php");
                } else {
                    header("Location: ../iniciar_sesion/paginaCarga.php");
                }
                exit;
            }
        } else {
            return 'El usuario no ha sido activado.';
        }
    }
    return 'El usuario y/o contraseña son incorrectos.';
}

function esActivo($usuario, $con)
{
    $sql = $con->prepare("SELECT activacion FROM datos_usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    if ($row['activacion'] == 1) {
        return true;
    }
    return false;
}

function solicitarPassword($user_id, $con)
{
    $token = generarToken();

    $sql = $con->prepare("UPDATE datos_usuarios SET tokenpassword=?, passwordrequest=1 WHERE idusuario = ?");

    if ($sql->execute([$token, $user_id])) {
        return $token;
    }
    return null;
}

function verificarTokenRequest($user_id, $token, $con)
{
    $sql = $con->prepare("SELECT idusuario FROM datos_usuarios WHERE idusuario = ? AND tokenpassword LIKE ? AND passwordrequest=1 LIMIT 1");
    $sql->execute([$user_id, $token]);
    if ($sql->fetchColumn() > 0) {
        return true;
    }
    return false;
}

function actualizarPassword($user_id, $password, $con)
{
    $sql = $con->prepare("UPDATE datos_usuarios SET password=?, tokenpassword = '', passwordrequest=0 WHERE idusuario = ?");
    if ($sql->execute([$password, $user_id])) {
        return true;
    }
    return false;
}
