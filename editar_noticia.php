<?php
session_start();
include_once './config/config.php';
include_once './classes/noticias.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$noticia = new Noticia($db);

// Ações
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar'])) {
    $idnot = $_POST['id'];
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $noticia->atualizar($idnot, $titulo, $conteudo);
    header('Location: portal.php');
    exit;
}

// Verificar se o ID da notícia foi passado na URL
if (isset($_GET['id'])) {
    $idnot = $_GET['id'];
    $noticia_atual = $noticia->lerPorId($idnot);
    if (!$noticia_atual) {
        echo "Notícia não encontrada.";
        exit;
    }
} else {
    echo "ID da notícia não fornecido.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Notícia</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dist/hamburgers.css">
</head>

<body>
    <header class="navbar">
        <h1>Editar Notícia</h1>
        <button class="hamburger hamburger--collapse" type="button">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </button>
        <nav class="nav-links">
            <a href="gerenciar.php" class="button">Gerenciar Usuários</a>
            <a href="portal.php" class="button">Gerenciar Notícias</a>
        </nav>
    </header>

    <main>
        <!-- Formulário para atualizar a notícia -->
        <form method="post" action="editar_noticia.php">
            <input type="hidden" name="id" value="<?php echo $noticia_atual['idnot']; ?>">
            <input type="text" name="titulo" placeholder="Título" value="<?php echo $noticia_atual['titulo']; ?>"
                required>
            <textarea name="conteudo" rows="4" placeholder="Conteúdo"
                required><?php echo $noticia_atual['noticia']; ?></textarea>
            <button type="submit" name="atualizar">Atualizar</button>
        </form>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hamburger = document.querySelector('.hamburger');
            const navLinks = document.querySelector('.nav-links');

            hamburger.addEventListener('click', function () {
                hamburger.classList.toggle('is-active');
                navLinks.classList.toggle('active');
            });
        });
    </script>
</body>

</html>