<?php
include_once './config/config.php';
include_once './classes/noticias.php';

$noticia = new Noticia($db);
$noticias = $noticia->ler();
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
        <ul>
            <?php while ($row = $noticias->fetch(PDO::FETCH_ASSOC)): ?>
                <li>
                    <h2><?php echo $row['titulo']; ?></h2>
                    <p><?php echo $row['noticia']; ?></p>
                </li>
            <?php endwhile; ?>
        </ul>
    </main>
</body>
<footer class="site-footer">
    <div class="container">
        <p>&copy; 2024 noticias.com Todos os direitos reservados.</p>
    </div>
</footer>

</html>
