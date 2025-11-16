<?php
session_start();
session_unset(); // remove todas as variáveis da sessão
session_destroy(); // encerra a sessão
header("Location: login.php"); // redireciona para a página de login
exit();
?>
