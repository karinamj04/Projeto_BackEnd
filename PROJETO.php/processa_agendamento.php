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
$sql_verifica = "SELECT * FROM usuarios WHERE cpf = '$cpf'";
$resultado = mysqli_query($conn, $sql_verifica);

if (mysqli_num_rows($resultado) > 0) {
    // CPF existe → prosseguir com o agendamento
    $sql_agendar = "INSERT INTO agendamentos 
        (nome, email, cpf_paciente, telefone, id_especialidade, id_medico, data_consulta, horario, criado_em)
        VALUES 
        ('$nome', '$email', '$cpf', '$telefone', '$especialidade', '$medico', '$data', '$horario', NOW())";

    if (mysqli_query($conn, $sql_agendar)) {
        // Redirecionar para página de sucesso
        header("Location: sucesso_agendamento.php");
        exit;
    } else {
        // Erro ao inserir
        echo "Erro ao realizar agendamento: " . mysqli_error($conn);
    }
} else {
    // CPF não cadastrado → redirecionar para página de erro
    header("Location: erro_agendamento.php");
    exit;
}

// Fechar conexão
mysqli_close($conn);
?>
