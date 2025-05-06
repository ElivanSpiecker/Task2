<?php
session_start();
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $stmt = $conn->prepare("SELECT id, senha FROM usuario WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $senha_hash);
        $stmt->fetch();
        if (password_verify($senha, $senha_hash)) {
            $_SESSION["id_usuario"] = $id;
            header("Location: listar_tarefa.php");
            exit();
        }
    }
    echo "Email ou senha inválidos.";
}
?>

<form method="post">
    <input type="email" name="email" required placeholder="Email">
    <input type="password" name="senha" required placeholder="Senha">
    <button type="submit">Entrar</button>
</form>
