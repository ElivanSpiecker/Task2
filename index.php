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
    </style>
</head>
<body>

<h1>Listagem de Tarefas</h1>

<?php
include 'conexao.php'; // Inclua a conexão com o banco de dados

$sql = "SELECT idtarefa, descricao, data_criacao, data_prevista, data_encerramento, situacao FROM tarefa";
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
            </tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["idtarefa"] . "</td>
                <td>" . $row["descricao"] . "</td>
                <td>" . $row["data_criacao"] . "</td>
                <td>" . $row["data_prevista"] . "</td>
                <td>" . ($row["data_encerramento"] ? $row["data_encerramento"] : 'Não encerrada') . "</td>
                <td>" . $row["situacao"] . "</td>
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
