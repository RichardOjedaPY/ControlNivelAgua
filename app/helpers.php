<?php
function registrarEvento($pdo, $tipo, $nivel_actual = 'N/A') {
    $usuario = $_SESSION['usuario'] ?? 'ESP32'; // puede venir del sistema o del microcontrolador
    $stmt = $pdo->prepare("INSERT INTO log_eventos (tipo_evento, usuario, nivel_actual) VALUES (?, ?, ?)");
    $stmt->execute([$tipo, $usuario, $nivel_actual]);
}
