<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Bem-vindo ao Sistema de Tarefas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 100px;
            background-color: #f9f9f9;
        }
        h1 {
            color: #333;
        }
        .menu {
            margin-top: 40px;
        }
        .menu a {
            display: inline-block;
            margin: 10px;
            padding: 15px 30px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
        }
        .menu a.cadastrar {
            background-color: #28a745;
        }
        .menu a:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<h1>Bem-vindo ao Sistema de Tarefas</h1>
<p>Gerencie suas tarefas com praticidade.</p>

<div class="menu">
    <a href="login.php">Login</a>
    <a href="cadastrar_usuario.php" class="cadastrar">Cadastrar Usuário</a>
</div>

</body>
</html>
