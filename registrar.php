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
    if(!isset($_SESSION['usuario_id'])){
        header('Location: ./login.php');
    }
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
<main>
        <section id="register">
            <h1>Cadastro Usuário</h1>
            <form method="POST">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" placeholder="Nome" required>
                </div>
                <div class="form-group">
                    <label>Sexo:</label>
                    <label for="masculino">
                        <input type="radio" id="masculino" name="sexo" value="M" required> Masculino
                    </label>
                    <label for="feminino">
                        <input type="radio" id="feminino" name="sexo" value="F" required> Feminino
                    </label>
                </div>
                <div class="form-group">
                    <label for="fone">Telefone:</label>
                    <input type="text" id="fone" name="fone" placeholder="Telefone" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" placeholder="E-mail" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" placeholder="Senha" required>
                </div>
                <div class="button-group">
                    <button type="submit">Cadastrar</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>