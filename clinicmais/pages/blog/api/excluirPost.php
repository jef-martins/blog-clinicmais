<?php

require_once 'blogController.php';
require_once '../../../assets/configsApi/response.php';
require_once '../../../assets/configsApi/header.php';


if ( json_last_error() === JSON_ERROR_NONE ) {

    $postID = $input[ 'txtPostId' ] ?? null;

    if ( $postID ) {

        $post = new Blog();
        $post->excluirPost($postID);
        echo Response::json( 204, 'success');
    } else {
        echo Response::json( 400, 'failed - campos vazio' );
    }
} else {
    echo Response::json( 400, 'Erro ao decodificar Json' );
}
?>
