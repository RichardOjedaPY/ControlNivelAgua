<?php
require_once '../config/database.php';
require_once '../app/models/NivelModel.php';
require_once '../app/middleware.php';

soloUsuario();

$modelo = new NivelModel($pdo);
$historial = $modelo->obtenerHistorial(100); // últimos 100 registros
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Historial - AquaBalance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Historial de registros</h4>
    <a href="dashboard.php" class="btn btn-secondary">Volver</a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body table-responsive">
      <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
          <tr>
            <th>Fecha</th>
            <th>Nivel Alto</th>
            <th>Nivel Medio</th>
            <th>Nivel Bajo</th>
            <th>Motor</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($historial as $fila): ?>
          <tr>
            <td><?= $fila['fecha'] ?></td>
            <td><?= $fila['nivel_alto'] ? '✔️' : '❌' ?></td>
            <td><?= $fila['nivel_medio'] ? '✔️' : '❌' ?></td>
            <td><?= $fila['nivel_bajo'] ? '✔️' : '❌' ?></td>
            <td><?= $fila['estado_motor'] ? '<span class="badge bg-success">Encendido</span>' : '<span class="badge bg-secondary">Apagado</span>' ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>