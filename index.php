<?php
session_start();
include_once './config/config.php';
include_once './classes/usuario.php';
$usuario = new Usuario($db);
if ($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['email'])){
    $email = $_POST['email'];
    $senha = $_POST['senha'];
        if ($dados_usuario = $usuario->login(
            $email, $senha
        )){
            $_SESSION['usuario_id'] = $dados_usuario['id'];
            header('Location: portal.php');
            exit();
        }else{
            $mensagem_erro = "Credenciais inválidas!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <main>
        <section id="login">
            <h1>Login</h1>
            <form method="post">
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                <div class="button-group">
                    <button type="submit">Entrar</button>
                </div>
            </form>
            <div class="register-link">
                <p>Não tem uma conta? <a href="registrar.php">Registre-se aqui</a></p>
            </div>
        </section>
    </main>
</body>

</html>