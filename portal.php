<?php
session_start();
include_once './config/config.php';
include_once './classes/noticias.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $noticia = new Noticia($db);
    $idusu = $_SESSION['usuario_id']; // ID do usuário logado
    $data = date('Y-m-d'); // Data atual
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $noticia->criar($idusu, $data, $titulo, $conteudo);
    header('Location: portal.php');
    exit;
}

// Verificar se o usuário está logado (exemplo)
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$noticia = new Noticia($db);

// Ações
if (isset($_POST['criar'])) {
    $idusu = $_SESSION['usuario_id']; // ID do usuário logado
    $data = date('Y-m-d'); // Data atual
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $noticia->criar($idusu, $data, $titulo, $conteudo);
    header('Location: noticias.php');
    exit;
} elseif (isset($_POST['atualizar'])) {
    $idnot = $_POST['id'];
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $noticia->atualizar($idnot, $titulo, $conteudo);
    header('Location: noticias.php');
    exit;
} elseif (isset($_GET['deletar'])) {
    $idnot = $_GET['deletar'];
    $noticia->deletar($idnot);
    header('Location: noticias.php');
    exit;
}

// Ler todas as notícias
$noticias = $noticia->ler();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notícias</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dist/hamburgers.css">
</head>
<body>
<header class="navbar">
    <h1>Notícias</h1>
    <button class="hamburger hamburger--collapse" type="button">
        <span class="hamburger-box">
            <span class="hamburger-inner"></span>
        </span>
    </button>
    <nav class="nav-links">
        <a href="gerenciar.php" class="button">Gerenciar Usuário</a>
        <a href="logout.php" class="button">Sair</a>
    </nav>
</header>

<main>
    <!-- Formulário para criar ou atualizar notícias -->
    <form method="post">
        <input type="hidden" name="id" value="<?php echo isset($noticia_atual) ? $noticia_atual['idnot'] : ''; ?>">
        
        <div class="form-group">
            <input type="text" name="titulo" placeholder="Título" value="<?php echo isset($noticia_atual) ? $noticia_atual['titulo'] : ''; ?>" required>
        </div>
        
        <div class="form-group">
            <textarea name="conteudo" rows="6" placeholder="Conteúdo" required><?php echo isset($noticia_atual) ? $noticia_atual['noticia'] : ''; ?></textarea>
        </div>
        
        <div class="button-group">
            <?php if (isset($noticia_atual)): ?>
                <button type="submit" name="atualizar">Atualizar</button>
            <?php else: ?>
                <button type="submit" name="criar">Criar Notícia</button>
            <?php endif; ?>
        </div>
    </form>

    <!-- Lista de notícias existentes -->
    <ul>
        <?php while ($row = $noticias->fetch(PDO::FETCH_ASSOC)): ?>
            <li>
                <h2><?php echo $row['titulo']; ?></h2>
                <p><?php echo $row['noticia']; ?></p>
                <div class="actions">
                    <a class="edit" href="editar_noticia.php?id=<?php echo $row['idnot']; ?>">Editar</a>
                    <a class="delete" href="deletar_noticia.php?id=<?php echo $row['idnot']; ?>" onclick="return confirm('Tem certeza que deseja deletar esta notícia?')">Deletar</a>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>
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
