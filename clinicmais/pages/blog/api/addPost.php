<?php

require_once 'blogController.php';
require_once '../../../assets/configsApi/response.php';
require_once '../../../assets/configsApi/header.php';


if ( json_last_error() === JSON_ERROR_NONE ) {

    $titulo = $input[ 'txtTitulo' ] ?? null;
    $conteudo = $input[ 'txtConteudo' ] ?? null;
    $autor = $input[ 'txtAutor' ] ?? null;
    $dataPostagem = $input[ 'txtDataPostagem' ] ?? null;

    if ( $titulo && $conteudo && $autor && $dataPostagem ) {

        $post = new Blog();
        $ultimoID = $post->inserirPost( $titulo, $conteudo, $autor, $dataPostagem );
        $ultimoPost = $post->retornaPost( $ultimoID );
        echo Response::json( 201, 'success', $ultimoPost );
    } else {
        echo Response::json( 400, 'failed - campos vazio' );
    }
} else {
    echo Response::json( 400, 'Erro ao decodificar Json' );
}

?>
