<?php
include_once './config/config.php';
include_once './classes/noticias.php';

$noticia = new Noticia($db);
$noticias = $noticia->ler();
$items_per_page = 10; // Número de notícias por página
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $items_per_page;

$noticias = $noticia->lerPaginado($items_per_page, $offset); // Método ajustado para paginação
$total_items = $noticia->contarNoticias(); // Método para contar o total de notícias

$total_pages = ceil($total_items / $items_per_page);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notícias</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header class="navbar">
    <h1>Notícias Recentes</h1>
    <button class="hamburger hamburger--collapse" type="button">
        <span class="hamburger-box">
            <span class="hamburger-inner"></span>
        </span>
    </button>
    <nav class="nav-links">
        <a href="login.php" class="button">Entrar</a>
    </nav>
</header>
<main>
    <ul class="news-container">
        <?php while ($row = $noticias->fetch(PDO::FETCH_ASSOC)): ?>
            <li class="news-item">
                <h2><?php echo $row['titulo']; ?></h2>
                <p><?php echo $row['noticia']; ?></p>
            </li>
        <?php endwhile; ?>
    </ul>

    <!-- Paginação -->
    <nav class="pagination">
        <?php for ($page = 1; $page <= $total_pages; $page++): ?>
            <a href="?page=<?php echo $page; ?>" <?php if ($page == $current_page) echo 'class="active"'; ?>><?php echo $page; ?></a>
        <?php endfor; ?>
    </nav>
</main>
<footer class="site-footer">
    <div class="container">
        <p>&copy; 2024 noticias.com Todos os direitos reservados.</p>
    </div>
</footer>
</body>
</html>

