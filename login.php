<?php
session_start();
include_once './config/config.php';
include_once './classes/usuario.php';

$usuario = new Usuario($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $usuarioInfo = $usuario->login($email, $senha);

    if ($usuarioInfo) {
        $_SESSION['usuario_id'] = $usuarioInfo['id'];
        $_SESSION['usuario_nome'] = $usuarioInfo['nome']; // Armazenar o nome do usuário na sessão
        header('Location: portal.php');
        exit();
    } else {
        $mensagem_erro = "Credenciais inválidas!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <main>
        <section id="login">
            <h1>Login</h1>
            <form method="POST">
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" placeholder="E-mail" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" placeholder="Senha" required>
                </div>
                <div class="button-group">
                    <button type="submit">Entrar</button>
                </div>
            </form>
            <?php if (isset($mensagem_erro)): ?>
                <p><?php echo $mensagem_erro; ?></p>
            <?php endif; ?>
            <div class="register-link">
                <p>Esqueceu sua senha? <a href="solicitar_recuperacao.php">Redefinir aqui</a></p>
                <p>Não tem uma conta? <a href="registrar.php">Registre-se aqui</a></p>
            </div>
        </section>
    </main>
</body>
</html>
