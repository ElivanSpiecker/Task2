<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (email, senha) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $senha);

    if ($stmt->execute()) {
        echo "Usuário cadastrado com sucesso! <a href='login.php'>Login</a>";
    } else {
        echo "Erro ao cadastrar usuário: " . $conn->error;
    }
}
?>

<form method="post">
    <h2>Cadastro de Usuário</h2>
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Senha: <input type="password" name="senha" required></label><br>
    <button type="submit">Cadastrar</button>
</form>
