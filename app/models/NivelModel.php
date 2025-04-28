<?php
class NivelModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Insertar un nuevo registro desde el ESP32
    public function guardarNivel($alto, $medio, $bajo, $motor) {
        $stmt = $this->pdo->prepare("INSERT INTO nivel_agua (nivel_alto, nivel_medio, nivel_bajo, estado_motor) VALUES (?, ?, ?, ?)");
        $stmt->execute([$alto, $medio, $bajo, $motor]);
    }

    // Obtener el último estado del tanque (alternativo)
    public function obtenerUltimoRegistro() {
        $stmt = $this->pdo->query("SELECT * FROM nivel_agua ORDER BY id DESC LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener historial completo (para dashboard o gráficos)
    public function obtenerHistorial($limite = 100) {
        $stmt = $this->pdo->prepare("SELECT * FROM nivel_agua ORDER BY fecha DESC LIMIT ?");
        $stmt->bindValue(1, $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Método requerido por api_ultimo.php
    public function obtenerUltimo() {
        $stmt = $this->pdo->query("SELECT * FROM nivel_agua ORDER BY fecha DESC LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
