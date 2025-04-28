<?php
class UsuarioModel {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerPorUsuario($usuario) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>