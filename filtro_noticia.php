<?php

include_once './config/config.php';
include_once './classes/Noticia.php';

$noticia = new Noticia($db);

// Obter parâmetros de pesquisa e filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';

// Obter dados das notícias com filtros
$dados = $noticia->ler($search, $order_by);

?>

<form method="GET" class="search-form">
    <div class="form-group">
        <input type="text" name="search" placeholder="Pesquisar por título ou conteúdo" value="<?php echo htmlspecialchars($search); ?>" class="search-input">
    </div>
    <div class="form-group">
        <label class="search-label">
            <input type="radio" name="order_by" value="" <?php if ($order_by == '') echo 'checked'; ?>> Normal
        </label>
        <label class="search-label">
            <input type="radio" name="order_by" value="titulo" <?php if ($order_by == 'titulo') echo 'checked'; ?>> Ordem Alfabética
        </label>
        <label class="search-label">
            <input type="radio" name="order_by" value="data" <?php if ($order_by == 'data') echo 'checked'; ?>> Data
        </label>
    </div>
    <div class="button-group">
        <button type="submit" class="search-button">Pesquisar</button>
    </div>
</form>