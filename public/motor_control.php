 <?php
require_once '../config/database.php';
require_once '../app/middleware.php';

soloAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['estado'])) {
        http_response_code(400);
        echo 'Falta el parámetro estado';
        exit;
    }

    $estado = $_POST['estado'] === '1' ? 1 : 0;

    // Obtener niveles actuales
    $nivel = 'SINAGUA';
    $res = $pdo->query("SELECT nivel_alto, nivel_medio, nivel_bajo FROM nivel_agua ORDER BY id DESC LIMIT 1");
    $datos = $res->fetch();

    if ($datos['nivel_alto']) $nivel = 'ALTO';
    elseif ($datos['nivel_medio']) $nivel = 'MEDIO';
    elseif ($datos['nivel_bajo']) $nivel = 'BAJO';

    // Verificar si el tanque está lleno y se quiere encender
    if ($estado === 1 && $datos['nivel_alto']) {
        echo json_encode(['error' => 'El tanque ya está lleno. No se puede encender el motor manualmente.']);
        exit;
    }

    // Verificar si el tanque está vacío y se quiere apagar
    if ($estado === 0 && !$datos['nivel_alto'] && !$datos['nivel_medio'] && !$datos['nivel_bajo']) {
        echo json_encode(['error' => 'El tanque está vacío. No se recomienda apagar el motor de agua.']);
        exit;
    }

    // Si existe una fila, actualizar. Si no, insertar.
    $check = $pdo->query("SELECT COUNT(*) FROM motor_manual")->fetchColumn();
    if ($check > 0) {
        $stmt = $pdo->prepare("UPDATE motor_manual SET estado = ?, actualizado = NOW() WHERE id = 1");
        $stmt->execute([$estado]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO motor_manual (estado) VALUES (?)");
        $stmt->execute([$estado]);
    }

    // Registrar en log_eventos
    $usuario = $_SESSION['usuario'] ?? 'admin';
    $tipo = $estado ? 'manual-on' : 'manual-off';

    $log = $pdo->prepare("INSERT INTO log_eventos (tipo_evento, usuario, nivel_actual) VALUES (?, ?, ?)");
    $log->execute([$tipo, $usuario, $nivel]);

    echo json_encode(['ok' => true, 'estado' => $estado]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $estado = $pdo->query("SELECT estado FROM motor_manual WHERE id = 1")->fetchColumn();
    echo json_encode(['estado' => (int)$estado]);
    exit;
}

http_response_code(405);
echo 'Método no permitido';
?>
