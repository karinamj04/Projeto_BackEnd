<?php
header('Content-Type: application/json'); 

$servidor = "localhost";
$usuario = "root";   // padrão do XAMPP
$senha = "";         // padrão é vazio
$banco = "raiz_saude";

// Criando a conexão
$conn = new mysqli($servidor, $usuario, $senha, $banco);

if ($conn->connect_error) {
    echo json_encode([
        "ok" => false,
        "mensagem" => "Erro na conexão com o banco de dados."
    ]);
    exit();
}

// mantém pontos e traço
$cpf = trim($_POST['cpf'] ?? '');

if (empty($cpf)) {
    echo json_encode([
        "ok" => false,
        "mensagem" => "CPF não informado."
    ]);
    exit();
}

// busca exatamente o formato como está no banco (ex: 123.456.789-00)
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE cpf = ?");
$stmt->bind_param("s", $cpf);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode([
        "ok" => true,
        "existe" => true,
        "mensagem" => "CPF encontrado!"
    ]);
} else {
    echo json_encode([
        "ok" => true,
        "existe" => false,
        "mensagem" => "CPF não encontrado."
    ]);
}

$stmt->close();
$conn->close();
?>
