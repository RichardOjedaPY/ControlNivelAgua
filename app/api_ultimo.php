<?php
header('Content-Type: application/json');
require_once '../config/database.php';
require_once './models/NivelModel.php';

$modelo = new NivelModel($pdo);
$ultimo = $modelo->obtenerUltimo();

echo json_encode($ultimo);
?>