<?php
class Tarefa {
    public static function listar($conn, $filtros = []) {
        $where = [];
        $params = [];
        $types = '';

        if (!empty($filtros['situacao'])) {
            $where[] = "situacao = ?";
            $params[] = $filtros['situacao'];
            $types .= 's';
        }
        if (!empty($filtros['data_inicio'])) {
            $where[] = "data_criacao >= ?";
            $params[] = $filtros['data_inicio'];
            $types .= 's';
        }
        if (!empty($filtros['data_fim'])) {
            $where[] = "data_criacao <= ?";
            $params[] = $filtros['data_fim'];
            $types .= 's';
        }
        if (!empty($filtros['data_prevista'])) {
            $where[] = "data_prevista = ?";
            $params[] = $filtros['data_prevista'];
            $types .= 's';
        }
        if (!empty($filtros['data_criacao'])) {
            $where[] = "data_criacao = ?";
            $params[] = $filtros['data_criacao'];
            $types .= 's';
        }

        $sql = "SELECT * FROM tarefa";
        if ($where) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $stmt = $conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result();
    }

    public static function criar($conn, $dados) {
        if (empty(trim($dados['descricao'])) || empty($dados['data_prevista']) || empty($dados['situacao'])) {
            return false;
        }
        if (strlen($dados['descricao']) > 255) {
            return false;
        }
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dados['data_prevista'])) {
            return false;
        }

        $stmt = $conn->prepare("INSERT INTO tarefa (descricao, data_criacao, data_prevista, situacao) VALUES (?, NOW(), ?, ?)");
        $stmt->bind_param("sss", $dados['descricao'], $dados['data_prevista'], $dados['situacao']);
        return $stmt->execute();
    }

    public static function editar($conn, $id, $dados) {
        if (empty(trim($dados['descricao'])) || empty($dados['data_prevista']) || empty($dados['situacao'])) {
            return false;
        }

        $stmt = $conn->prepare("UPDATE tarefa SET descricao=?, data_prevista=?, data_encerramento=?, situacao=? WHERE idtarefa=?");
        $stmt->bind_param("ssssi", $dados['descricao'], $dados['data_prevista'], $dados['data_encerramento'], $dados['situacao'], $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public static function excluir($conn, $id) {
        $stmt = $conn->prepare("DELETE FROM tarefa WHERE idtarefa = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
