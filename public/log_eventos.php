 <?php
require_once '../config/database.php';
require_once '../app/middleware.php';

soloUsuario();

$logs = $pdo->query("SELECT * FROM log_eventos ORDER BY fecha DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Log de Eventos - AquaBalance</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>📋 Historial de eventos del sistema</h3>
    <a href="dashboard.php" class="btn btn-outline-secondary">← Volver al Dashboard</a>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Evento</th>
          <th>Usuario</th>
          <th>Nivel al momento</th>
          <th>Fecha y hora</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($logs as $log): ?>
        <tr>
          <td><?= $log['id'] ?></td>
          <td>
            <?php
              switch ($log['tipo_evento']) {
                case 'manual-on': echo '🔘 Encendido manual'; break;
                case 'manual-off': echo '⏹ Apagado manual'; break;
                case 'auto-on': echo '🔄 Encendido automático'; break;
                case 'auto-off': echo '🛑 Apagado automático'; break;
                default: echo ucfirst($log['tipo_evento']);
              }
            ?>
          </td>
          <td><?= htmlspecialchars($log['usuario']) ?></td>
          <td><?= $log['nivel_actual'] ?></td>
          <td><?= date('d/m/Y H:i:s', strtotime($log['fecha'])) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
