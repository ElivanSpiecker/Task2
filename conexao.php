<?php
// Lê o arquivo .env na mesma pasta
$env = parse_ini_file(__DIR__ . '/.env');

// Parâmetros de conexão
$servername = "127.0.0.1";
$username = "root";
$password = "123";
$dbname = $env['DB_NAME']; // Vem do .env

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>
