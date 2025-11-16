<?php
include 'conexao.php';
session_start();

if (!isset($_SESSION['email'])) {
    echo 'erro_sessao';
    exit();
}

$id = $_POST['id'] ?? null;
$novo_status = $_POST['status'] ?? null;

if (!$id || !$novo_status) {
    echo 'erro_parametros';
    exit();
}

// Verifica se o status é válido
$validos = ['pendente', 'confirmada', 'cancelada'];
if (!in_array($novo_status, $validos)) {
    echo 'status_invalido';
    exit();
}

// Atualiza no banco
$stmt = $conn->prepare("UPDATE agendamentos SET status = ? WHERE id = ? AND email = ?");
$stmt->bind_param('sis', $novo_status, $id, $_SESSION['email']);

if ($stmt->execute()) {
    echo 'ok';
} else {
    echo 'erro_sql';
}
?>
