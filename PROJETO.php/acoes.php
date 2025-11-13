<?php
require 'conexao.php';
session_start();

/* Criar usuário */
if (isset($_POST['create_usuario'])) {
    $cpf = mysqli_real_escape_string($conn, trim($_POST['cpf']));
    $nome = mysqli_real_escape_string($conn, trim($_POST['nome']));
    $sobrenome = mysqli_real_escape_string($conn, trim($_POST['sobrenome']));
    $nomeMaterno = mysqli_real_escape_string($conn, trim($_POST['nomeMaterno']));
    $sexo = mysqli_real_escape_string($conn, trim($_POST['sexo']));
    $endereco = mysqli_real_escape_string($conn, trim($_POST['endereco']));
    $bairro = mysqli_real_escape_string($conn, trim($_POST['bairro']));
    $estado = mysqli_real_escape_string($conn, trim($_POST['estado']));
    $cep = mysqli_real_escape_string($conn, trim($_POST['cep']));
    $cidade = mysqli_real_escape_string($conn, trim($_POST['cidade']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $DataNascimento = mysqli_real_escape_string($conn, trim($_POST['DataNascimento']));
    $telefoneCelular = mysqli_real_escape_string($conn, trim($_POST['telefoneCelular']));

    // 🔹 Define senha padrão
    $senhaPadrao = "123456";
    $senhaCriptografada = password_hash($senhaPadrao, PASSWORD_DEFAULT);

    // 🔹 Flag para forçar troca de senha no primeiro login
    $trocar_senha = 1;

    // 🔹 Insere usuário
    $sql = "INSERT INTO usuarios 
            (cpf, nome, sobrenome, nomeMaterno, sexo, endereco, bairro, estado, cep, cidade, email, senha, telefoneCelular, DataNascimento, trocar_senha)
            VALUES ('$cpf', '$nome', '$sobrenome', '$nomeMaterno', '$sexo', '$endereco', '$bairro', '$estado', '$cep', '$cidade', '$email', '$senhaCriptografada', '$telefoneCelular', '$DataNascimento', '$trocar_senha')";

    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['mensagem'] = "✅ Usuário criado com sucesso! Senha padrão: 123456";
        header('Location: crud.php');
        exit;
    } else {
        $_SESSION['mensagem'] = "❌ Erro ao criar usuário.";
        header('Location: crud.php');
        exit;
    }
}


/* Atualizar usuário */
if(isset($_POST['update_usuario'])){
    $usuario_cpf = mysqli_real_escape_string($conn,$_POST['usuario_cpf']);
    $cpf = mysqli_real_escape_string($conn, trim($_POST['cpf']));
    $nome = mysqli_real_escape_string($conn, trim($_POST['nome']));
    $sobrenome = mysqli_real_escape_string($conn, trim($_POST['sobrenome']));
    $nomeMaterno = mysqli_real_escape_string($conn, trim($_POST['nomeMaterno']));
    $sexo = mysqli_real_escape_string($conn, trim($_POST['sexo']));
    $endereco = mysqli_real_escape_string($conn, trim($_POST['endereco']));
    $bairro = mysqli_real_escape_string($conn, trim($_POST['bairro']));
    $estado = mysqli_real_escape_string($conn, trim($_POST['estado']));
    $cep = mysqli_real_escape_string($conn, trim($_POST['cep']));
    $cidade = mysqli_real_escape_string($conn, trim($_POST['cidade']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $DataNascimento = mysqli_real_escape_string($conn, trim($_POST['DataNascimento']));
    $telefoneCelular = mysqli_real_escape_string($conn, trim($_POST['telefoneCelular']));
    $senha = trim($_POST['senha']);

    $sql = "UPDATE usuarios SET 
        cpf='$cpf', nome='$nome', sobrenome='$sobrenome', nomeMaterno='$nomeMaterno', sexo='$sexo',
        endereco='$endereco', bairro='$bairro', estado='$estado', cep='$cep', cidade='$cidade',
        email='$email', telefoneCelular='$telefoneCelular', DataNascimento='$DataNascimento'";

    if(!empty($senha)) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $sql .= ", senha='$senhaHash'";
    }

    $sql .= " WHERE cpf='$usuario_cpf'";

    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['mensagem'] = "✅ Usuário atualizado com sucesso!";
        header('Location: crud.php');
        exit;
    } else {
        $_SESSION['mensagem'] = "⚠️ Nenhuma alteração feita";
        header('Location: crud.php');
        exit;
    }
}

/* Deletar usuário */
if(isset($_POST['delete_usuario'])){
    $usuario_cpf = mysqli_real_escape_string($conn, $_POST['delete_usuario']);

    $sql = "DELETE FROM usuarios WHERE cpf='$usuario_cpf'";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['mensagem'] = "✅ Usuário excluído!";
        header('Location: crud.php');
        exit;
    } else {
        $_SESSION['mensagem'] = "❌ Erro ao excluir usuário";
        header('Location: crud.php');
        exit;
    }
}
?>
