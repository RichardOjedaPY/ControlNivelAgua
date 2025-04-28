 <?php
require_once '../config/database.php';
require_once '../app/models/NivelModel.php';

$modelo = new NivelModel($pdo);
$ultimo = $modelo->obtenerUltimo();

// Obtener también estado manual
$manual = $pdo->query("SELECT estado FROM motor_manual WHERE id = 1")->fetchColumn();

$ultimo['estado_manual'] = (int)$manual;

header('Content-Type: application/json');
echo json_encode($ultimo);
?>