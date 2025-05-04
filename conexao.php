<?php
$servername = "127.0.0.1:3306";  // Use apenas "localhost" ou "127.0.0.1"
$username = "root";         // Seu usuário MySQL
$password = "123";  // Substitua pela sua senha (deixe em branco se não houver senha)
$dbname = "task2";          // Nome do banco de dados

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("A conexão falhou: " . $conn->connect_error);
} else {
    echo "Conexão bem-sucedida!";
}
?>
