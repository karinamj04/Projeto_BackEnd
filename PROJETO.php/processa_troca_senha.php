<?php
session_start();
include('conexao.php');

if (!isset($_SESSION['email_troca'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novaSenha = $_POST['novaSenha'];
    $confirmarSenha = $_POST['confirmarSenha'];

    if ($novaSenha === $confirmarSenha) {
        $email = $_SESSION['email_troca'];
        $senhaCriptografada = password_hash($novaSenha, PASSWORD_DEFAULT);

        $sql = "UPDATE usuarios 
                SET senha='$senhaCriptografada', trocar_senha=0 
                WHERE email='$email'";
        mysqli_query($conn, $sql);

        // Remove sessão temporária
        unset($_SESSION['email_troca']);
        unset($_SESSION['nome_troca']);

        $_SESSION['mensagem'] = "Senha alterada com sucesso! Faça login novamente.";
        header('Location: login.php');
        exit();
    } else {
        echo "<script>alert('As senhas não coincidem.'); history.back();</script>";
    }
}
?>
