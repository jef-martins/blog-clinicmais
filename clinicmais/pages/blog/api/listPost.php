<?php

require_once 'blogController.php';
require_once '../../../assets/configsApi/response.php';
require_once '../../../assets/configsApi/header.php';


$post = new Blog();

$titulo = $input[ 'txtTitulo' ] ?? null;
$pagina = $input[ 'txtPagina' ] ?? 1;

if($titulo)
    $post = $post->listarPostTitulo($titulo);
else
    $post = $post->listarPost($pagina);

echo Response::json( 200, 'success', $post);
?>
