<?php
session_start();
require 'conexao.php';
require 'classes/tarefa.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID inválido.";
    exit();
}

$id = (int) $_GET['id'];

// Opcional: verificar se a tarefa existe antes de excluir
$stmt = $conn->prepare("SELECT idtarefa FROM tarefa WHERE idtarefa = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Tarefa não encontrada.";
    exit();
}

// Excluir tarefa
if (Tarefa::excluir($conn, $id)) {
    header("Location: listar_tarefa.php");
    exit();
} else {
    echo "Erro ao excluir tarefa.";
}
?>
