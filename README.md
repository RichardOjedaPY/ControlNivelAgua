# Microsotec AquaBalance

Sistema de monitoreo y control automático del nivel de agua en tanque, utilizando ESP32 y un servidor web en PHP + MySQL.

---

## 📊 Descripción del Proyecto

Microsotec AquaBalance es un sistema completo que:
- Mide el nivel de agua (alto, medio y bajo) usando sensores conectados a un ESP32.
- Controla automáticamente un motor de agua basado en los niveles detectados.
- Envía los datos al servidor para monitoreo en tiempo real.
- Registra eventos y estados en una base de datos MySQL.
- Ofrece una interfaz web responsive para visualizar información y controlar manualmente el motor.

---

## 🛠️ Tecnologías Utilizadas

- **Hardware**:
  - ESP32 DevKit V1
  - Sensores de nivel de agua tipo flotador
  - Relé de 5V con optoacoplador
  - Buzzer piezoeléctrico
  - LEDs indicadores

- **Software**:
  - Arduino IDE (programación del ESP32)
  - PHP 8+
  - MySQL / MariaDB
  - HTML5, CSS3 (Bootstrap opcional)
  - AJAX (para actualizaciones en tiempo real)

---

## 📦 Instalación del Sistema

### 1. ESP32
- Abrir el archivo `esp32-funciona.txt` en Arduino IDE.
- Configurar tu SSID, contraseña de WiFi y URL de tu servidor:
  ```cpp
  const char* ssid = "TU_SSID";
  const char* password = "TU_PASSWORD";
  const String servidor = "http://tusitio.com/data/receive_data.php";
  ```
- Subir el sketch al ESP32.

### 2. Servidor Web (PHP + MySQL)
- Subir los archivos del directorio `public_html/` a tu hosting o servidor local (XAMPP, Laragon, etc).
- Crear una base de datos en MySQL e importar el archivo `microsotec_aquabalance.sql`.
- Editar `config/database.php` con tus credenciales de base de datos:
  ```php
  $host = "localhost";
  $dbname = "microsotec_aquabalance";
  $username = "root";
  $password = "";
  ```

### 3. Ajustes Adicionales
- Asegúrate que tu servidor acepte solicitudes HTTP GET.
- Configura permisos de escritura si deseas almacenar logs o históricos.

---

## 🔗 Estructura Principal del Proyecto

```bash
/public_html
  |- app/             # Modelos, controladores y helpers
  |- config/          # Configuración de base de datos
  |- data/            # Scripts de recepción de datos del ESP32
  |- public/          # Archivos públicos (login, dashboard, módulos)
  |- routes/          # Definición de rutas de navegación
  |- .htaccess        # Seguridad de directorios
  |- index.php        # Punto de entrada principal
```

---

## 🚀 Características del Sistema

- Monitoreo en tiempo real de los niveles de agua.
- Encendido y apagado automático del motor según niveles.
- Alarmas visuales y sonoras (buzzer) en niveles críticos.
- Historial de eventos y control manual del motor desde el dashboard.
- Sistema seguro de acceso mediante login.
- Base de datos organizada para registrar y analizar comportamiento del sistema.

---

## ⚡ Requisitos Mínimos

- ESP32 configurado correctamente.
- Hosting o servidor local con PHP 8.0 o superior.
- Base de datos MySQL 5.7 o superior.
- Conexión a Internet estáble para el ESP32 y el servidor.

---

## 🔒 Notas de Seguridad

- Nunca subas tus credenciales WiFi reales o contraseñas de bases de datos en repositorios públicos.
- Usa archivos `.gitignore` para proteger configuraciones sensibles.
- Asegura tu servidor PHP con HTTPS si lo conectas a Internet.

---

## 📚 Licencia

Este proyecto está disponible para fines educativos y de aprendizaje. Uso comercial bajo consulta.

---

 

## 📚 Autor

Este proyecto fue desarrollado por **Richard Ojeda (Microsotec)** en 2025.

> Inspirado en la necesidad de automatizar y optimizar el uso de recursos hídricos de manera sencilla y eficiente.


