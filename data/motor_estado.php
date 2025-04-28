<?php
require_once '../config/database.php';

$stmt = $pdo->query("SELECT estado FROM motor_manual WHERE id = 1 LIMIT 1");
$estado = $stmt->fetchColumn();
echo $estado !== false ? $estado : '0';
?>