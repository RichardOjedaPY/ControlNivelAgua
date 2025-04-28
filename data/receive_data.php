<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../config/database.php';

if (
    isset($_GET['nivel_alto'], $_GET['nivel_medio'], $_GET['nivel_bajo'], $_GET['estado_motor'])
) {
    $nivel_alto = $_GET['nivel_alto'];
    $nivel_medio = $_GET['nivel_medio'];
    $nivel_bajo = $_GET['nivel_bajo'];
    $estado_motor = $_GET['estado_motor'];
    $nivel_actual = $_GET['nivel_actual'] ?? 'SINAGUA'; // <- agregamos esto

    $stmt = $pdo->prepare("INSERT INTO nivel_agua (nivel_alto, nivel_medio, nivel_bajo, estado_motor, nivel_actual) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nivel_alto, $nivel_medio, $nivel_bajo, $estado_motor, $nivel_actual]);

    echo "Datos recibidos correctamente.";
} else {
    echo "Faltan parámetros.";
}
?>

