<?php
session_start();
require_once '../config/database.php';
require_once '../app/models/NivelModel.php';
require_once '../app/middleware.php';
soloUsuario();

$modelo = new NivelModel($pdo);
$ultimo = $modelo->obtenerUltimo();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - AquaBalance</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    .led {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: #444;
      margin: 10px;
      display: inline-block;
    }
    .led.alto.on { background-color: #0d6efd; }
    .led.medio.on { background-color: #ffc107; }
    .led.bajo.on { background-color: #dc3545; }

    .alerta-nivel-bajo, .alerta-nivel-alto {
      font-weight: bold;
      padding: 15px;
      text-align: center;
      display: none;
    }

    .alerta-nivel-bajo {
      background-color: #dc3545;
      color: white;
    }

    .alerta-nivel-alto {
      background-color: #ffc107;
      color: black;
      animation: parpadeo 1s infinite;
    }

    @keyframes parpadeo {
      0%, 100% { background-color: #ffc107; }
      50% { background-color: #fff3cd; }
    }

    .toggle-container {
      margin-top: 20px;
    }
    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }
    .switch input { display: none; }
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0; left: 0;
      right: 0; bottom: 0;
      background-color: #ccc;
      transition: 0.4s;
      border-radius: 34px;
    }
    .slider:before {
      position: absolute;
      content: "";
      height: 26px; width: 26px;
      left: 4px; bottom: 4px;
      background-color: white;
      transition: 0.4s;
      border-radius: 50%;
    }
    input:checked + .slider {
      background-color: #28a745;
    }
    input:checked + .slider:before {
      transform: translateX(26px);
    }
  </style>
</head>
<body class="bg-light">
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Estado actual del tanque</h3>
    <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
  </div>

  <!-- ALERTAS -->
  <div id="alertaBajo" class="alerta-nivel-bajo">Nivel de agua bajo detectado!</div>
  <div id="alertaAlto" class="alerta-nivel-alto">⚠️ ¡El tanque está lleno! No se puede encender el motor manualmente.</div>
  <div id="alertaVacio" class="alerta-nivel-bajo">❌ ¡El tanque está vacío! No se recomienda apagar el motor de agua.</div>

  <div class="card shadow-sm mb-3">
    <div class="card-body text-center">
      <div>
        <div class="led alto" id="ledAlto"></div>
        <div class="led medio" id="ledMedio"></div>
        <div class="led bajo" id="ledBajo"></div>
      </div>
      <div class="mt-2">
        <small class="me-4">Nivel Alto</small>
        <small class="me-4">Nivel Medio</small>
        <small>Nivel Bajo</small>
      </div>
      <hr>
      <h5>Motor de agua: <span id="estadoMotor" class="badge"></span></h5>
      <small class="text-muted" id="ultimaFecha">Última actualización: <?= $ultimo['fecha'] ?></small>

      <?php if ($_SESSION['rol'] === 'admin'): ?>
      <div class="toggle-container text-center">
        <label class="switch">
          <input type="checkbox" id="manualToggle">
          <span class="slider"></span>
        </label>
        <div class="mt-2">
          <small>Control manual del motor: <span id="estadoTexto">--</span></small>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="d-flex flex-wrap gap-2">
    <a href="grafico.php" class="btn btn-outline-primary">Ver gráfico</a>
    <a href="historial.php" class="btn btn-outline-secondary">Ver historial</a>
    <a href="resumen_motor.php" class="btn btn-outline-success">Resumen del motor</a>
    <a href="modulos_aquabalance.php" class="btn btn-outline-dark">Todos los módulos</a>
    <a href="log_eventos.php" class="btn btn-outline-warning">📄 Log de eventos</a>
  </div>
</div>

<audio id="buzzer" src="https://www.soundjay.com/buttons/sounds/beep-07.mp3" preload="auto"></audio>

<script>
function verificarNivelBajo() {
  $.getJSON('../app/api_ultimo.php', function(data) {
    if (data.nivel_bajo == 1 && data.nivel_alto == 0) {
      $('#alertaBajo').fadeIn();
      document.getElementById('buzzer').play();
    } else {
      $('#alertaBajo').fadeOut();
    }
  });
}

function actualizarEstadoTanque() {
  $.getJSON('../app/api_estado_tanque.php', function(data) {
    $('#ledAlto').toggleClass('on', data.nivel_alto == 1);
    $('#ledMedio').toggleClass('on', data.nivel_medio == 1);
    $('#ledBajo').toggleClass('on', data.nivel_bajo == 1);

    const estadoMotor = $('#estadoMotor');
    if (data.estado_motor == 1) {
      estadoMotor.removeClass('bg-danger').addClass('bg-success').text('Encendido');
    } else {
      estadoMotor.removeClass('bg-success').addClass('bg-danger').text('Apagado');
    }

    $('#ultimaFecha').text('Última actualización: ' + data.fecha);

    if (data.estado_manual !== undefined) {
      const toggle = $('#manualToggle');
      const estadoTexto = $('#estadoTexto');
      toggle.prop('checked', data.estado_manual == 1);
      estadoTexto.text(data.estado_manual == 1 ? 'ON' : 'OFF');
    }
  });
}

setInterval(verificarNivelBajo, 5000);
setInterval(actualizarEstadoTanque, 5000);

$(document).ready(function() {
  actualizarEstadoTanque();

  const toggle = $('#manualToggle');
  const estadoTexto = $('#estadoTexto');

  $.getJSON('../data/motor_estado.php', function(data) {
    toggle.prop('checked', data.estado == 1);
    estadoTexto.text(data.estado == 1 ? 'ON' : 'OFF');
  });

  toggle.on('change', function () {
    const estado = this.checked ? 1 : 0;

    $.getJSON('../app/api_ultimo.php', function (data) {
      const estaLleno = data.nivel_alto == 1;
      const estaVacio = data.nivel_alto == 0 && data.nivel_medio == 0 && data.nivel_bajo == 0;

      if (estado === 1 && estaLleno) {
        $('#alertaAlto').fadeIn().delay(4000).fadeOut();
        toggle.prop('checked', false);
        estadoTexto.text('OFF');
        return;
      }

      if (estado === 0 && estaVacio) {
        $('#alertaVacio').fadeIn().delay(4000).fadeOut();
        toggle.prop('checked', true);
        estadoTexto.text('ON');
        return;
      }

      $.post('motor_control.php', { estado }, function(resp) {
        estadoTexto.text(estado === 1 ? 'ON' : 'OFF');
        console.log('Motor manual actualizado', resp);
      });
    });
  });
});
</script>
</body>
</html>
