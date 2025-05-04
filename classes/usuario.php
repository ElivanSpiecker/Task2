<?php
class Usuario {
    public static function cadastrar($conn, $nome, $email, $senha) {
        if (empty(trim($nome)) || empty(trim($email)) || empty(trim($senha))) {
            return false;
        }

        // Verificar se e-mail já existe
        $stmt = $conn->prepare("SELECT id FROM usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            return false;
        }

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO usuario (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $senha_hash);
        return $stmt->execute();
    }

    public static function login($conn, $email, $senha) {
        if (empty($email) || empty($senha)) return false;

        $stmt = $conn->prepare("SELECT senha FROM usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) return false;

        $row = $result->fetch_assoc();
        return password_verify($senha, $row['senha']);
    }
}
