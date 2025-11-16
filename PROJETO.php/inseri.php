<?php
// Conexão com o banco
include ('conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recebendo dados do formulário
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $DataNascimento = $_POST['dataNascimento'];
    $NomeMaterno = $_POST['nomeMaterno'];
    $Cpf = $_POST['cpf'];
    $sexo = $_POST['sexo'];
    $cep = $_POST['cep'];
    $endereco = $_POST['endereco'];
    $bairro = $_POST['bairro'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefoneCelular'];

    // Criptografa a senha antes de enviar para o banco
    $hash = password_hash($senha, PASSWORD_DEFAULT);
    //Validação para saber se ja existe o email e o cpf existente dentro do banco

    // Conexão com o banco
    include 'conexao.php'; 

    // Prepara o SQL para evitar SQL Injection
    $sql = "INSERT INTO usuarios 
    (cpf, nome, sobrenome, nomeMaterno, sexo, endereco, bairro, estado, cep, cidade, email, senha, telefoneCelular, DataNascimento) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssssssssss",
        $Cpf,
        $nome,
        $sobrenome,
        $NomeMaterno,
        $sexo,
        $endereco,
        $bairro,
        $estado,
        $cep,
        $cidade,
        $email,
        $hash,
        $telefone,
        $DataNascimento
    );

    if ($stmt->execute()) {
        header('Location: login.php');
        exit;
    }else{
        header('Location: erroGeral.php');
        exit;
    }
    $stmt->close();
    $conn->close();
}