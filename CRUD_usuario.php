<?php

include_once './config/config.php';
include_once './classes/usuario.php';

$usuario = new Usuario($db);

// Obter parâmetros de pesquisa e filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';

// Obter dados dos usuários com filtros
$dados = $usuario->ler($search, $order_by);

?>

<form method="GET" class="search-form">
    <div class="form-group">
        <input type="text" name="search" placeholder="Pesquisar " value="<?php echo htmlspecialchars($search); ?>" class="search-input">
    </div>
    <div class="form-group">
        <label class="search-label">
            <input type="radio" name="order_by" value="" <?php if ($order_by == '') echo 'checked'; ?>> Normal
        </label>
        <label class="search-label">
            <input type="radio" name="order_by" value="nome" <?php if ($order_by == 'nome') echo 'checked'; ?>> Ordem Alfabética
        </label>
        <label class="search-label">
            <input type="radio" name="order_by" value="sexo" <?php if ($order_by == 'sexo') echo 'checked'; ?>> Sexo
        </label>
    </div>
    <div class="button-group">
        <button type="submit" class="search-button">Pesquisar</button>
    </div>
</form>