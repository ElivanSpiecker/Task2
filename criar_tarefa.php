<?php
session_start();
require 'conexao.php';
require 'classes/Tarefa.php';
require 'email.php';

// Processar o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'descricao' => $_POST['descricao'],
        'data_prevista' => $_POST['data_prevista'],
        'situacao' => $_POST['situacao']
    ];
    if (Tarefa::criar($conn, $dados)) {
        enviarEmail("destinatario@exemplo.com", "Nova Tarefa Criada", "A tarefa '{$dados['descricao']}' foi criada.");
        header("Location: listar_tarefa.php");
        exit();
    } else {
        echo "Erro ao criar tarefa.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Nova Tarefa</title>
</head>
<body>

<h2>Criar Nova Tarefa</h2>

<form method="post">
    <label>Descrição:<br>
        <input type="text" name="descricao" required>
    </label><br><br>

    <label>Data Prevista:<br>
        <input type="date" name="data_prevista" required>
    </label><br><br>

    <label>Situação:<br>
        <select name="situacao" required>
            <option value="pendente">Pendente</option>
            <option value="concluida">Concluída</option>
        </select>
    </label><br><br>

    <button type="submit">Criar Tarefa</button>
</form>

<p><a href="index.php">Voltar</a></p>

</body>
</html>
