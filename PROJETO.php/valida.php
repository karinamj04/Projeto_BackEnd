<?php
session_start();
include('conexao.php'); // Conexão usando $conn

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Busca usuário pelo email
    $query = "SELECT * FROM usuarios WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $usuario = mysqli_fetch_assoc($result);

        // ✅ Se o usuário precisa trocar a senha, envia direto
        if ($usuario['trocar_senha'] == 1) {
            $_SESSION['email_troca'] = $usuario['email'];
            $_SESSION['nome_troca'] = $usuario['nome'];

            header('Location: trocar_senha.php');
            exit();
        }

        // Caso contrário, faz a verificação normal da senha
        if (password_verify($senha, $usuario['senha'])) {

            // Armazena dados do usuário na sessão
            $_SESSION['id_usuario'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['telefone'] = $usuario['telefone'];
            $_SESSION['cpf'] = $usuario['cpf'];
            $_SESSION['data_nascimento'] = $usuario['data_nascimento'];

            // Variáveis temporárias usadas na 2FA
            $_SESSION['email_temp'] = $usuario['email'];
            $_SESSION['nome_temp'] = $usuario['nome'];

            // Redireciona para autenticação de dois fatores
            header('Location: 2fa.php');
            exit();

        } else {
            // Senha incorreta
            header('Location: login.php?erro=senha');
            exit();
        }

    } else {
        // E-mail não encontrado
        header('Location: login.php?erro=email');
        exit();
    }

} else {
    header('Location: login.php');
    exit();
}
?>
