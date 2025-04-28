<?php
session_start();

function soloAdmin() {
    if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
        header("Location: ../public/login.php");
        exit();
    }
}

function soloUsuario() {
    if (!isset($_SESSION['usuario'])) {
        header("Location: ../public/login.php");
        exit();
    }
}
?>
