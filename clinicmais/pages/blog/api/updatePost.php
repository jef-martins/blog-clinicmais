<?php

require_once 'blogController.php';
require_once '../../../assets/configsApi/response.php';
require_once '../../../assets/configsApi/header.php';

if ( json_last_error() === JSON_ERROR_NONE ) {

    $postID = $input[ 'txtPostId' ] ?? null;
    $titulo = $input[ 'txtTitulo' ] ?? null;
    $conteudo = $input[ 'txtConteudo' ] ?? null;
    $autor = $input[ 'txtAutor' ] ?? null;
    $dataPostagem = $input[ 'txtDataPostagem' ] ?? null;

    if ( $postID && $titulo && $conteudo && $autor && $dataPostagem ) {

        $post = new Blog();
        $post->atualizarPost($postID, $titulo, $conteudo, $autor, $dataPostagem );
        $retornarPost = $post->retornaPost($postID);
        echo Response::json( 200, 'success', [$postID , $titulo , $conteudo, $autor , $dataPostagem]);
    } else {
        echo Response::json( 400, 'failed - campos vazio' );
    }
} else {
    echo Response::json( 400, 'Erro ao decodificar Json' );
}
?>
