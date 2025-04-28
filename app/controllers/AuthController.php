<?php
require_once '../config/database.php';
require_once '../app/models/UsuarioModel.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    $modelo = new UsuarioModel($pdo);
    $user = $modelo->obtenerPorUsuario($usuario);

    if ($user && hash('sha256', $clave) === $user['clave']) {
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['rol'] = $user['rol'];
        header("Location: dashboard.php");
    } else {
        $error = "Credenciales inválidas";
        include './app/views/login.php';
    }
} else {
    include '../app/views/login.php';
}
?>