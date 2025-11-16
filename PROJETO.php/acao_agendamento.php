<?php
include 'conexao.php';
session_start();

if (!isset($_SESSION['email']) || $_SESSION['tipo'] !== 'admin') {
    echo 'erro_sessao';
    exit();
}

$id = $_GET['id'] ?? null;
$acao = $_GET['acao'] ?? null;

if (!$id || !$acao) {
    echo 'erro_parametros';
    exit();
}

$mapa = [
    'confirmar' => 'confirmada',
    'cancelar' => 'cancelada',
    'realizada' => 'realizada',
    'nao_realizada' => 'nao_realizada'
];

if (!isset($mapa[$acao])) {
    echo 'acao_invalida';
    exit();
}

$novo_status = $mapa[$acao];

$stmt = $conn->prepare("UPDATE agendamentos SET status = ? WHERE id = ?");
$stmt->bind_param('si', $novo_status, $id);

if ($stmt->execute()) {
    echo ucfirst(str_replace('_', ' ', $novo_status)); // exibe algo legível tipo “Consulta realizada”
} else {
    echo 'erro_sql';
}
?>
