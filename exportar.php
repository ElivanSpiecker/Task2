<?php
require 'vendor/autoload.php';
require 'conexao.php';
use Dompdf\Dompdf;

// Montar os filtros
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

// Query com filtros
$sql = "SELECT * FROM tarefa";
if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$result = $conn->query($sql);

// Gerar conteúdo HTML
$html = "<h2 style='text-align: center;'>Relatório de Tarefas</h2>";
$html .= "<table border='1' cellpadding='5' cellspacing='0' width='100%'>
<tr>
    <th>ID</th>
    <th>Descrição</th>
    <th>Data de Criação</th>
    <th>Data Prevista</th>
    <th>Data de Encerramento</th>
    <th>Situação</th>
</tr>";

while ($row = $result->fetch_assoc()) {
    $html .= "<tr>
        <td>{$row['idtarefa']}</td>
        <td>{$row['descricao']}</td>
        <td>{$row['data_criacao']}</td>
        <td>{$row['data_prevista']}</td>
        <td>" . ($row['data_encerramento'] ?: 'Não encerrada') . "</td>
        <td>{$row['situacao']}</td>
    </tr>";
}
$html .= "</table>";

// Exportar PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("tarefas.pdf", ["Attachment" => false]);
exit;
