 <?php
session_start();
if (isset($_SESSION['usuario'])) {
    header('Location: ../../public/dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>AquaBalance - Iniciar sesión</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f8;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-box {
      width: 100%;
      max-width: 400px;
      padding: 30px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .login-box h4 {
      text-align: center;
      margin-bottom: 25px;
      font-weight: bold;
      color: #0d6efd;
    }

    .form-control {
      border-radius: 8px;
    }

    .btn-primary {
      border-radius: 8px;
      font-weight: bold;
    }

    @media (max-width: 400px) {
      .login-box {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

<div class="login-box">
  <h4>AquaBalance - Iniciar sesión</h4>

  <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger text-center">Usuario o contraseña incorrectos.</div>
  <?php endif; ?>

  <form action="../../public/procesar_login.php" method="POST">
    <div class="mb-3">
      <label for="usuario" class="form-label">Usuario</label>
      <input type="text" class="form-control" id="usuario" name="usuario" required>
    </div>
    <div class="mb-3">
      <label for="clave" class="form-label">Contraseña</label>
      <input type="password" class="form-control" id="clave" name="clave" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Ingresar</button>
  </form>
</div>

</body>
</html>
