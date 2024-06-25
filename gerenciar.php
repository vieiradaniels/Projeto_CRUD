<?php

session_start();
include_once './config/config.php';
include_once './classes/usuario.php';

//verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}
$usuario = new Usuario($db);

//Processar exclusão de usuário
if (isset($_GET['deletar'])) {
    $id_usuario = $_GET['deletar'];
    $usuario->deletar($id);
    header('Location: portal.php');
    exit;
}
//Obter dados do usuário logado
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_usuario['nome'];
//Obter dados dos usuários
$dados = $usuario->ler();
//Função para determinar a saudação
function saudacao()
{
    $hora = date('H');
    if ($hora >= 6 && $hora < 12) {
        return 'Bom dia';
    } elseif ($hora >= 12 && $hora < 18) {
        return 'Boa tarde';
    } else {
        return 'Boa noite';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dist/hamburgers.css">
</head>
<body>
    <header class="navbar">
        <h1><?php echo saudacao() . ", " . $nome_usuario; ?>!</h1>
        <button class="hamburger hamburger--collapse" type="button">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </button>
        <nav class="nav-links">
            <a href="registrar.php" class="button">Adicionar Usuário</a>
            <a href="logout.php" class="button">Logout</a>
        </nav>
    </header>
    <main class="gerenciar-main">
        <div class="table-responsive">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Sexo</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nome']; ?></td>
                            <td><?php echo ($row['sexo'] === 'M') ? 'Masculino' : 'Feminino'; ?></td>
                            <td><?php echo $row['fone']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td>
                                <a href="editar.php?id=<?php echo $row['id']; ?>" class="action-button">Editar</a>
                                <a href="deletar.php?id=<?php echo $row['id']; ?>" class="action-button delete" onclick="return confirm('Tem certeza que deseja deletar esta notícia?')">Deletar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.querySelector('.hamburger');
            const navLinks = document.querySelector('.nav-links');

            hamburger.addEventListener('click', function() {
                hamburger.classList.toggle('is-active');
                navLinks.classList.toggle('active');
            });
        });
    </script>
</body>
</html>

