<?php
// Tenta carregar .env; se não existir, usa getenv()
$env = file_exists(__DIR__ . '/.env')
    ? parse_ini_file(__DIR__ . '/.env')
    : [];

// Host e porta (forçam TCP em vez de socket)
$host     = $env['DB_HOST']     ?? getenv('DB_HOST')     ?? '127.0.0.1';
$port     = isset($env['DB_PORT']) ? (int)$env['DB_PORT'] : (getenv('DB_PORT') ?: 3306);
$user     = $env['DB_USER']     ?? getenv('DB_USER')     ?? 'root';
$password = $env['DB_PASS']     ?? getenv('DB_PASS')     ?? '';
$dbname   = $env['DB_NAME']     ?? getenv('DB_NAME')     ?? '';

$conn = new mysqli($host, $user, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
