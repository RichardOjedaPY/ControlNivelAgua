<?php
require_once '../config/database.php';

if (!isset($_GET['accion'])) {
    http_response_code(400);
    echo "Falta el parámetro 'accion'.";
    exit;
}

$accion = $_GET['accion'];

if ($accion === 'on') {
    // Insertar nuevo inicio
    $stmt = $pdo->prepare("INSERT INTO motor_registro (inicio) VALUES (NOW())");
    $stmt->execute();
    echo "Motor ENCENDIDO registrado.";
} elseif ($accion === 'off') {
    // Buscar el último inicio sin fin
    $stmt = $pdo->query("SELECT id, inicio FROM motor_registro WHERE fin IS NULL ORDER BY id DESC LIMIT 1");
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($registro) {
        $id = $registro['id'];
        $stmt = $pdo->prepare("UPDATE motor_registro SET fin = NOW(), duracion_segundos = TIMESTAMPDIFF(SECOND, inicio, NOW()) WHERE id = ?");
        $stmt->execute([$id]);
        echo "Motor APAGADO registrado y duración calculada.";
    } else {
        echo "No se encontró inicio sin fin.";
    }
} else {
    echo "Acción inválida. Usa 'on' o 'off'.";
}
?>
