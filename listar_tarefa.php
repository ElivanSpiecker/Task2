<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Tarefas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .actions a {
            margin: 0 5px;
            text-decoration: none;
            padding: 4px 8px;
            background-color: #007BFF;
            color: white;
            border-radius: 4px;
        }
        .actions a.excluir {
            background-color: #dc3545;
        }
        .top-bar {
            margin-bottom: 20px;
        }
        form.filtros {
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }
        form.filtros label {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>

<h1>Listagem de Tarefas</h1>

<div class="top-bar">
    <a href="criar_tarefa.php" style="background-color: #28a745; color: white; padding: 8px 12px; border-radius: 4px; text-decoration: none;">+ Nova Tarefa</a>
</div>

<form method="get" class="filtros">
    <label>ID:
        <input type="number" name="id" value="<?= $_GET['id'] ?? '' ?>">
    </label>
    <label>Descrição:
        <input type="text" name="descricao" value="<?= $_GET['descricao'] ?? '' ?>">
    </label>
    <label>Data de Criação:
        <input type="date" name="data_criacao" value="<?= $_GET['data_criacao'] ?? '' ?>">
    </label>
    <label>Data Prevista:
        <input type="date" name="data_prevista" value="<?= $_GET['data_prevista'] ?? '' ?>">
    </label>
    <label>Data de Encerramento:
        <input type="date" name="data_encerramento" value="<?= $_GET['data_encerramento'] ?? '' ?>">
    </label>
    <label>Situação:
        <select name="situacao">
            <option value="">Todas</option>
            <option value="pendente" <?= ($_GET['situacao'] ?? '') == 'pendente' ? 'selected' : '' ?>>Pendente</option>
            <option value="concluida" <?= ($_GET['situacao'] ?? '') == 'concluida' ? 'selected' : '' ?>>Concluída</option>
        </select>
    </label>
    <button type="submit">Filtrar</button>
</form>

<form method="get" action="exportar.php" style="margin-bottom: 20px;">
    <?php foreach ($_GET as $key => $value): ?>
        <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
    <?php endforeach; ?>
    <button type="submit">Exportar para PDF</button>
</form>


<?php
include 'conexao.php';

$where = [];
if (!empty($_GET['id'])) {
    $where[] = "idtarefa = " . (int)$_GET['id'];
}
if (!empty($_GET['descricao'])) {
    $desc = $conn->real_escape_string($_GET['descricao']);
    $where[] = "descricao LIKE '%$desc%'";
}
if (!empty($_GET['data_criacao'])) {
    $where[] = "data_criacao = '" . $conn->real_escape_string($_GET['data_criacao']) . "'";
}
if (!empty($_GET['data_prevista'])) {
    $where[] = "data_prevista = '" . $conn->real_escape_string($_GET['data_prevista']) . "'";
}
if (!empty($_GET['data_encerramento'])) {
    $where[] = "data_encerramento = '" . $conn->real_escape_string($_GET['data_encerramento']) . "'";
}
if (!empty($_GET['situacao'])) {
    $where[] = "situacao = '" . $conn->real_escape_string($_GET['situacao']) . "'";
}

$sql = "SELECT idtarefa, descricao, data_criacao, data_prevista, data_encerramento, situacao FROM tarefa";
if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Data de Criação</th>
                <th>Data Prevista</th>
                <th>Data de Encerramento</th>
                <th>Situação</th>
                <th>Ações</th>
            </tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row["idtarefa"]}</td>
                <td>{$row["descricao"]}</td>
                <td>{$row["data_criacao"]}</td>
                <td>{$row["data_prevista"]}</td>
                <td>" . ($row["data_encerramento"] ?: 'Não encerrada') . "</td>
                <td>{$row["situacao"]}</td>
                <td class='actions'>
                    <a href='editar_tarefa.php?id={$row["idtarefa"]}'>Editar</a>
                    <a href='excluir_tarefa.php?id={$row["idtarefa"]}' class='excluir' onclick=\"return confirm('Deseja realmente excluir esta tarefa?');\">Excluir</a>
                </td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "Nenhuma tarefa encontrada.";
}

$conn->close();
?>

</body>
</html>
