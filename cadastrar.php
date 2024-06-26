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
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <main class="form-container">
        <h1>Cadastro Usuário</h1>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="nome" placeholder="Nome" required>
            </div>
            <div class="form-group">
                <label>
                    <input type="radio" name="sexo" value="M" required>
                    Masculino
                </label>
                <label>
                    <input type="radio" name="sexo" value="F" required>
                    Feminino
                </label>
            </div>
            <div class="form-group">
                <input type="text" name="fone" placeholder="Telefone" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="E-mail" required>
            </div>
            <div class="form-group">
                <input type="password" name="senha" placeholder="Senha" required>
            </div>
            <div class="button-group">
                <input type="submit" value="Cadastrar">
            </div>
        </form>
    </main>
</body>
</html>