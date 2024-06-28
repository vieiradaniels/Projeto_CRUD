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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idnot = $_POST['id'];
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $noticia->atualizar($idnot, $titulo, $conteudo);
    header('Location: gerenciar_noticia.php');
    exit;
} elseif (isset($_GET['id'])) {
    $idnot = $_GET['id'];
    $noticia_atual = $noticia->lerPorIdNot($idnot);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Notícia</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header class="navbar">
    <h1>Editar Notícia</h1>
    <nav class="nav-links">
        <a href="gerenciar_noticia.php" class="button">Voltar</a>
        <a href="logout.php" class="button">Sair</a>
    </nav>
</header>
<main>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo isset($noticia_atual['idnot']) ? $noticia_atual['idnot'] : ''; ?>">
        
        <div class="form-group">
            <input type="text" name="titulo" placeholder="Título" value="<?php echo isset($noticia_atual['titulo']) ? $noticia_atual['titulo'] : ''; ?>" required>
        </div>
        
        <div class="form-group">
            <textarea name="conteudo" rows="6" placeholder="Conteúdo" required><?php echo isset($noticia_atual['noticia']) ? $noticia_atual['noticia'] : ''; ?></textarea>
        </div>
        
        <div class="button-group">
            <button type="submit" name="atualizar">Atualizar</button>
        </div>
    </form>
</main>
</body>
</html>
