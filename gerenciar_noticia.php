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
if (isset($_GET['deletar'])) {
    $idnot = $_GET['deletar'];
    $noticia->deletar($idnot);
    header('Location: gerenciar_noticia.php');
    exit;
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $idusu = $_SESSION['usuario_id']; // Supondo que o ID do usuário esteja na sessão
    $data = date("Y-m-d H:i:s");
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];

    // Insere a notícia no banco de dados
    $noticia->criar($idusu, $data, $titulo, $conteudo);

    // Redireciona para a página de gerenciamento de notícias
    header("Location: gerenciar_noticia.php");
    exit();
}

// Ler todas as notícias
$noticias = $noticia->lerPorId($_SESSION['usuario_id']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Notícias</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dist/hamburgers.css">
</head>

<body>
    <header class="navbar">
        <h1>Gerenciar Notícias</h1>
        <nav class="nav-links">
            <a href="portal.php" class="button">Voltar</a>
            <a href="logout.php" class="button">Sair</a>
        </nav>
    </header>
    <?php require './CRUD_noticia.php' ?>
    <main>
        <!-- Formulário de Criação de Notícia -->
        <section>
            <h2>Criar Nova Notícia</h2>
            <form method="post" action="gerenciar_noticia.php">
                <div class="form-group">
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" required>
                </div>
                <div class="form-group">
                    <label for="conteudo">Conteúdo:</label>
                    <textarea id="conteudo" name="conteudo" required></textarea>
                </div>
                <div class="button-group">
                    <button type="submit" class="button">Salvar</button>
                </div>
            </form>
        </section>
        <!-- Lista de Notícias -->
        <ul>
            <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)): ?>
                <li>
                    <h2><?php echo $row['titulo']; ?></h2>
                    <p><?php echo $row['noticia']; ?></p>
                    <div class="actions">
                        <a class="edit" href="editar_noticia.php?id=<?php echo $row['idnot']; ?>">Editar</a>
                        <a class="delete" href="gerenciar_noticia.php?deletar=<?php echo $row['idnot']; ?>"
                            onclick="return confirm('Tem certeza que deseja deletar esta notícia?')">Deletar</a>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    </main>
</body>

</html>