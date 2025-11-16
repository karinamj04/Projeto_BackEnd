<?php
include('conexao.php');

if (isset($_GET['id_especialidade'])) {
    $id_especialidade = intval($_GET['id_especialidade']);

    $sql = "SELECT id, nome FROM medicos WHERE id_especialidade = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_especialidade);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<option value="">Selecione o médico</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="'.$row['id'].'">'.$row['nome'].'</option>';
    }
}
?>
