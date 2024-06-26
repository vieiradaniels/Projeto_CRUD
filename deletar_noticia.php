<?php

session_start();
if(!isset($_SESSION['usuario_id'])){
    header('Location: index.php');
    exit();
}

include_once './config/config.php';
include_once './classes/noticias.php';

$noticia = new Noticia($db);
if (isset($_GET['id'])){
    $id = $_GET['id'];
    $noticia->deletar($id);
    header('Location: portal.php');
    exit();
}
?>