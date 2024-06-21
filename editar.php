<?php

session_start();
if(!isset($_SESSION['usuario_id'])){
    header('Location: index.php');
    exit();
}

include_once './config/config.php';
include_once './classes/usuario.php';

$usuario = new Usuario($db);
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $POST['id'];
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $usuario->atualizar ($id, $nome, $sexo, $fone, $email);
    header('Location: portal.php');
    exit();
}
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $row = $usuario->lerPorId($id);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
</head>
<body>
    <h1>Editar Usuário</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="<?php echo $row['nome']; ?>" required><br><br>
        <label>Sexo:</label>
        <label for="masculino_editar"></label>
        <input type="radio" id="masculino_editar" name="sexo" value="M" <?php echo ($row['sexo'] === 'M')  ? 'checked' : ''; ?> required> Masculino</label>
        <label for="feminino_editar"></label>
        <input type="radio" id="feminino_editar" name="sexo" value="F" <?php echo ($row['sexo'] === 'F')  ? 'checked' : ''; ?> required> Feminino</label><br><br>
        <label for="fone">Telefone:</label>
        <input type="tel" name="fone" value="<?php echo $row['fone']; ?>" required><br><br>
        <label for="email">E-mail:</label>
        <input type="email" name="email" value="<?php echo $row['email']; ?>" required><br><br>
        <input type="submit" value="Atualizar">
    </form>
</body>
</html>