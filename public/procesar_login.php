<?php
session_start();

$usuario = $_POST['usuario'] ?? '';
$clave = $_POST['clave'] ?? '';

// 🔐 Validación simple (podés reemplazar con tu lógica real de DB)
if ($usuario === 'admin' && $clave === '1234') {
    $_SESSION['usuario'] = $usuario;
    $_SESSION['rol'] = 'admin'; // o 'usuario'
    header('Location: dashboard.php');
    exit;
} else {
    header('Location: ../app/views/login.php?error=1');
    exit;
}
