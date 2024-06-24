<?php
include_once './config/config.php';
include_once './classes/usuario.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo'];
    $nova_senha = $_POST['nova_senha'];
    $usuario = new Usuario($db);
    if ($usuario->redefinirSenha($codigo, $nova_senha)) {
        $mensagem = 'Senha redefinida com sucesso. Você pode <a href="index.php">entrar</a> agora.';
    } else {
        $mensagem = 'Código de verificação inválido.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<main>
    <h1>Redefinir Senha</h1>
    <form method="POST">
        <div class="form-group">
            <label for="codigo">Código de Verificação:</label>
            <input type="text" name="codigo" value="Seu código aqui" required>
        </div>
        <div class="form-group">
            <label for="nova_senha">Nova Senha:</label>
            <input type="password" name="nova_senha" required>
        </div>
        <div class="button-group">
            <input type="submit" value="Redefinir Senha">
        </div>
    </form>
    <p><?php echo $mensagem; ?></p>
</main>
</body>
</html>