<?php
require_once '../config/database.php';

if (isset($_GET['accion'])) {
    $accion = $_GET['accion']; // "on" o "off"
    $usuario = 'ESP32';

    // Obtener nivel actual
    $nivel = 'SINAGUA';
    $res = $pdo->query("SELECT nivel_alto, nivel_medio, nivel_bajo FROM nivel_agua ORDER BY id DESC LIMIT 1");
    $datos = $res->fetch();
    if ($datos['nivel_alto']) $nivel = 'ALTO';
    elseif ($datos['nivel_medio']) $nivel = 'MEDIO';
    elseif ($datos['nivel_bajo']) $nivel = 'BAJO';

    $tipo = $accion === 'on' ? 'auto-on' : 'auto-off';

    $log = $pdo->prepare("INSERT INTO log_eventos (tipo_evento, usuario, nivel_actual) VALUES (?, ?, ?)");
    $log->execute([$tipo, $usuario, $nivel]);

    echo 'Log guardado';
}
?>
