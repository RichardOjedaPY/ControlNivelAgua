
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Módulos - AquaBalance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-4 text-center">📋 Panel de módulos AquaBalance</h2>

    <div class="list-group">
      <a href="/public/dashboard.php" class="list-group-item list-group-item-action">
        1️⃣ Estado actual del tanque (Dashboard)
      </a>
      <a href="/public/historial.php" class="list-group-item list-group-item-action">
        2️⃣ Historial de registros
      </a>
      <a href="/public/grafico.php" class="list-group-item list-group-item-action">
        3️⃣ Historial gráfico del nivel de agua
      </a>
      <a href="/public/resumen_motor.php" class="list-group-item list-group-item-action">
        4️⃣ Resumen de uso del motor (por día / mes)
      </a>
      <a href="/public/alerta.php" class="list-group-item list-group-item-action text-danger">
        5️⃣ Alerta visual de nivel BAJO (¡Nuevo!)
      </a>
    </div>

    <div class="text-center mt-5">
      <a href="/public/dashboard.php" class="btn btn-primary">Volver al Dashboard</a>
    </div>
  </div>
</body>
</html>
