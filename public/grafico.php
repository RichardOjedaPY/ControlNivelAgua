<?php
require_once '../config/database.php';
require_once '../app/models/NivelModel.php';
require_once '../app/middleware.php';

soloUsuario();

$modelo = new NivelModel($pdo);
$registros = $modelo->obtenerHistorial(50); // Últimos 50 registros

// Convertir nivel_actual en valores numéricos para el gráfico
function nivelToValor($nivel) {
    if (!$nivel) return 0;
    switch (strtoupper($nivel)) {
        case 'ALTO': return 3;
        case 'MEDIO': return 2;
        case 'BAJO': return 1;
        default: return 0;
    }
}


$labels = [];
$niveles = [];
$motores = [];

foreach ($registros as $fila) {
    $labels[] = date('H:i:s', strtotime($fila['fecha']));
    $niveles[] = nivelToValor($fila['nivel_actual']);
    $motores[] = (int)$fila['estado_motor'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gráfico - AquaBalance</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Historial gráfico del nivel de agua</h4>
    <a href="dashboard.php" class="btn btn-secondary">Volver</a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <canvas id="nivelChart" height="100"></canvas>
    </div>
  </div>
</div>

<script>
const ctx = document.getElementById('nivelChart').getContext('2d');

const chart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: <?= json_encode($labels) ?>,
    datasets: [
      {
        label: 'Nivel del agua',
        data: <?= json_encode($niveles) ?>,
        borderColor: 'blue',
        backgroundColor: 'rgba(0,123,255,0.1)',
        tension: 0.3
      },
      {
        label: 'Estado del motor',
        data: <?= json_encode($motores) ?>,
        borderColor: 'green',
        backgroundColor: 'rgba(40,167,69,0.1)',
        tension: 0.3,
        yAxisID: 'motor-y'
      }
    ]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        title: {
          display: true,
          text: 'Nivel de agua'
        },
        ticks: {
          stepSize: 1,
          callback: function(value) {
            switch(value) {
              case 0: return "SIN AGUA";
              case 1: return "BAJO";
              case 2: return "MEDIO";
              case 3: return "ALTO";
            }
          }
        },
        min: 0,
        max: 3
      },
      'motor-y': {
        position: 'right',
        title: {
          display: true,
          text: 'Motor (0=Apagado, 1=Encendido)'
        },
        min: 0,
        max: 1,
        ticks: {
          stepSize: 1
        },
        grid: {
          drawOnChartArea: false
        }
      }
    }
  }
});
</script>
</body>
</html>
