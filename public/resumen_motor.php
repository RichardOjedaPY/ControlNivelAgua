<?php
require_once '../config/database.php';
require_once '../app/middleware.php';

soloUsuario();

function obtenerResumen($pdo, $modo) {
    if ($modo === 'dia') {
        $sql = "SELECT fecha, COUNT(*) AS ciclos, SUM(duracion_segundos) AS total_segundos
                FROM motor_registro
                GROUP BY fecha
                ORDER BY fecha DESC LIMIT 30";
    } elseif ($modo === 'mes') {
        $sql = "SELECT DATE_FORMAT(inicio, '%Y-%m') AS periodo, COUNT(*) AS ciclos, SUM(duracion_segundos) AS total_segundos
                FROM motor_registro
                GROUP BY periodo
                ORDER BY periodo DESC LIMIT 12";
    } else {
        return [];
    }

    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

$modo = $_GET['modo'] ?? 'dia';
$resumen = obtenerResumen($pdo, $modo);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resumen del motor - AquaBalance</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Resumen de uso del motor de agua</h4>
    <a href="dashboard.php" class="btn btn-secondary">Volver</a>
  </div>

  <ul class="nav nav-tabs mb-3">
    <li class="nav-item">
      <a class="nav-link <?= $modo === 'dia' ? 'active' : '' ?>" href="?modo=dia">Por día</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= $modo === 'mes' ? 'active' : '' ?>" href="?modo=mes">Por mes</a>
    </li>
  </ul>

  <table class="table table-bordered table-striped table-hover">
    <thead class="table-primary">
      <tr>
        <th><?= $modo === 'dia' ? 'Fecha' : 'Mes' ?></th>
        <th>Ciclos</th>
        <th>Duración total</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($resumen as $fila): ?>
      <tr>
        <td><?= $modo === 'dia' ? $fila['fecha'] : $fila['periodo'] ?></td>
        <td><?= $fila['ciclos'] ?></td>
        <td>
          <?php
            $total = $fila['total_segundos'] ?? 0;
            $h = floor($total / 3600);
            $m = floor(($total % 3600) / 60);
            $s = $total % 60;
            printf('%02dh %02dm %02ds', $h, $m, $s);
          ?>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body>
</html>
