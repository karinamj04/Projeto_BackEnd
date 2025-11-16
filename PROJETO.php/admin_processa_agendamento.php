<?php
include("conexao.php");

// Receber dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];
$especialidade = $_POST['especialidade'];
$medico = $_POST['medico'];
$data = $_POST['data'];
$horario = $_POST['horario'];

// Verificar se o CPF existe na tabela de usuários
$sql_verifica = "SELECT cpf FROM usuarios WHERE cpf = ?";
$stmt = $conn->prepare($sql_verifica);
$stmt->bind_param("s", $cpf);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {

    $sql_agendar = "INSERT INTO agendamentos
        (nome, email, cpf_paciente, telefone, id_especialidade, id_medico, data_consulta, horario, criado_em)
        VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt2 = $conn->prepare($sql_agendar);
    $stmt2->bind_param(
        "ssssiiis",
        $nome,
        $email,
        $cpf,
        $telefone,
        $especialidade,
        $medico,
        $data,
        $horario
    );

    if ($stmt2->execute()) {
        echo "sucesso";
    } else {
        echo "erro";
    }

} else {
    echo "cpf_inexistente";
}

$conn->close();
?>
