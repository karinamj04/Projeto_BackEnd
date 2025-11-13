<?php
$servidor = "localhost";
$usuario = "root";   // padrão do XAMPP
$senha = "";         // padrão é vazio
$banco = "raiz_saude";

// Criando a conexão
$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Checando se deu certo
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
} else {
   ;
}
?>
 