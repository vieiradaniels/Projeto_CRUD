<?php
include_once './config/config.php';
include_once './classes/usuario.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario($db);
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $usuario->registrar($nome, $sexo, $fone, $email, $senha);
    header('Location: index.php');
    exit();
}
?>;

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Cadastro Usuário</h1>
    <form method="POST">
        <input type="text" name="nome" placeholder="nome" required>
        <br><label>Masculino</label>
        <input type="radio" name="sexo" value="M" required>
        <br><label>Feminino</label>
        <input type="radio" name="sexo" value="F" required>
        <br>
        <input type="text" name="fone" placeholder="Telefone" required>
        <br>
        <input type="email" name="email" placeholder="E-mail" required>
        <br>
        <input type="password" name="senha" placeholder="Senha" required>
        <br>
        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>