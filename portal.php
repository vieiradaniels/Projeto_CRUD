<?php
session_start();
include_once './config/config.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header class="navbar">
    <h1>Portal de Gerenciamento</h1>
    <button class="hamburger hamburger--collapse" type="button">
        <span class="hamburger-box">
            <span class="hamburger-inner"></span>
        </span>
    </button>
</header>
<main class="portal-main">
    <div class="button-group">
        <a href="gerenciar.php" class="button">Gerenciar Usuários</a>
        <a href="gerenciar_noticia.php" class="button">Gerenciar Notícias</a>
    </div>
</main>
</body>
</html>