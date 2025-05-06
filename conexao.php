<?php
$servername = "127.0.0.1:3306";  // Use apenas "localhost" ou "127.0.0.1"
$username = "root";         // Seu usuário MySQL
$password = "123";  // Substitua pela sua senha (deixe em branco se não houver senha)
$dbname = "meu_banco";          // Nome do banco de dados

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

?>
