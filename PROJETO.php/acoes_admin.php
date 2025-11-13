<?php
include('conexao.php');
session_start();

if (isset($_POST['criar_admin'])) {

    // 🔹 Campos obrigatórios
    $cpf            = trim($_POST['cpf']); // mantém pontos e traços
    $nome           = trim($_POST['nome']);
    $email          = trim($_POST['email']);
    $nomeMaterno    = trim($_POST['nomeMaterno']);
    $cep            = trim($_POST['cep']);
    $DataNascimento = trim($_POST['DataNascimento']);

    // 🔹 Gera senha temporária automática
    $senhaPadrao = substr(bin2hex(random_bytes(4)), 0, 8); // Ex: a7b2f9c1
    $senhaCriptografada = password_hash($senhaPadrao, PASSWORD_DEFAULT);

    // 🔹 Flags fixas
    $tipo = 'admin';
    $trocar_senha = 1;

    // 🔹 Verifica se já existe usuário com mesmo CPF ou e-mail
    $verifica = $conn->prepare("SELECT cpf FROM usuarios WHERE cpf = ? OR email = ?");
    $verifica->bind_param("ss", $cpf, $email);
    $verifica->execute();
    $verifica->store_result();

    if ($verifica->num_rows > 0) {
        $_SESSION['mensagem'] = " Já existe um usuário com este CPF ou e-mail.";
        $verifica->close();
        header('Location: criar_acesso.php');
        exit();
    }
    $verifica->close();

    // 🔹 Insere novo administrador com todos os campos necessários
    $sql = "INSERT INTO usuarios (cpf, nome, email, senha, nomeMaterno, cep, DataNascimento, tipo, trocar_senha, criado_em)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssi", 
        $cpf, $nome, $email, $senhaCriptografada, $nomeMaterno, $cep, $DataNascimento, $tipo, $trocar_senha
    );
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['mensagem'] = " Acesso de administrador criado com sucesso! ";
    } else {
        $_SESSION['mensagem'] = " Erro ao criar o acesso: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header('Location: criar_acesso.php');
    exit();
}
?>
