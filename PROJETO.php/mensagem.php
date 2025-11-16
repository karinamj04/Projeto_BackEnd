<?php
// Inicia a sessão apenas se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('conexao.php'); // sua conexão padrão com $conn

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION['email']) || $_SESSION['tipo'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Exibe mensagem de alerta, se existir
if (isset($_SESSION['mensagem'])):
?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['mensagem'], ENT_QUOTES, 'UTF-8'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
<?php
    // Remove a mensagem da sessão após exibir
    unset($_SESSION['mensagem']);
endif;
?>
