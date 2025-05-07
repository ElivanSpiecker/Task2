<?php
session_start();
require 'conexao.php';
require 'classes/tarefa.php';
require 'email.php';

$id = $_GET['id'];
$tarefa = null;

// Carregar dados da tarefa
$sql = "SELECT * FROM tarefa WHERE idtarefa = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $tarefa = $result->fetch_assoc();
} else {
    echo "Tarefa não encontrada.";
    exit();
}

// Atualizar tarefa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'descricao' => $_POST['descricao'],
        'data_prevista' => $_POST['data_prevista'],
        'data_encerramento' => $_POST['data_encerramento'],
        'situacao' => $_POST['situacao']
    ];
    if (Tarefa::editar($conn, $id, $dados)) {
        enviarEmail("eli.spiecker@gmail.com", "Tarefa Atualizada", "A tarefa '{$dados['descricao']}' foi atualizada.");
        header("Location: listar_tarefa.php");
        exit();
    } else {
        echo "Erro ao editar tarefa.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Tarefa</title>
</head>
<body>

<h2>Editar Tarefa</h2>

<form method="post">
    <label>Descrição:<br>
        <input type="text" name="descricao" required value="<?php echo htmlspecialchars($tarefa['descricao']); ?>">
    </label><br><br>

    <label>Data Prevista:<br>
        <input type="date" name="data_prevista" required value="<?php echo $tarefa['data_prevista']; ?>">
    </label><br><br>

    <label>Data de Encerramento:<br>
        <input type="date" name="data_encerramento" value="<?php echo $tarefa['data_encerramento']; ?>">
    </label><br><br>

    <label>Situação:<br>
        <select name="situacao" required>
            <option value="Pendente" <?php echo $tarefa['situacao'] === 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
            <option value="Concluida" <?php echo $tarefa['situacao'] === 'Concluida' ? 'selected' : ''; ?>>Concluída</option>
            <option value="Andamento" <?php echo $tarefa['situacao'] === 'Andamento' ? 'selected' : ''; ?>>Andamento</option>
        </select>
    </label><br><br>

    <button type="submit">Salvar Alterações</button>
</form>

<p><a href="listar_tarefa.php">Voltar</a></p>

</body>
</html>
