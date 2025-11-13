<?php
header('Content-Type: application/json');
include('conexao.php'); 

// Verifica se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'ok' => false,
        'mensagem' => 'Método de requisição inválido.'
    ]);
    exit();
}

// Coleta os dados do formulário
$cpf = trim($_POST['cpf'] ?? '');
$novaSenha = trim($_POST['novaSenha'] ?? '');
$confirmarSenha = trim($_POST['confirmarSenha'] ?? '');

// Validações básicas
if (empty($cpf) || empty($novaSenha) || empty($confirmarSenha)) {
    echo json_encode([
        'ok' => false,
        'mensagem' => 'Por favor, preencha todos os campos.'
    ]);
    exit();
}

// Verifica se as senhas coincidem
if ($novaSenha !== $confirmarSenha) {
    echo json_encode([
        'ok' => false,
        'mensagem' => 'As senhas não coincidem.'
    ]);
    exit();
}

// Exige senha mínima de 6 caracteres
if (strlen($novaSenha) < 6) {
    echo json_encode([
        'ok' => false,
        'mensagem' => 'A senha deve ter pelo menos 6 caracteres.'
    ]);
    exit();
}

// Criptografa a senha com segurança
$senhaCriptografada = password_hash($novaSenha, PASSWORD_DEFAULT);

// Verifica se o CPF existe no banco
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE cpf = ?");
$stmt->bind_param("s", $cpf);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        'ok' => false,
        'mensagem' => 'CPF não encontrado. Verifique e tente novamente.'
    ]);
    exit();
}

// Atualiza a senha no banco
$update = $conn->prepare("UPDATE usuarios SET senha = ? WHERE cpf = ?");
$update->bind_param("ss", $senhaCriptografada, $cpf);

if ($update->execute()) {
    echo json_encode([
        'ok' => true,
        'mensagem' => 'Senha alterada com sucesso!'
    ]);
} else {
    echo json_encode([
        'ok' => false,
        'mensagem' => 'Erro ao atualizar a senha. Tente novamente.'
    ]);
}

// Fecha conexões
$stmt->close();
$update->close();
$conn->close();
?>
