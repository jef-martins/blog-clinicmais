<?php
header( 'Content-Type: application/json' );
$inputJSON = file_get_contents( 'php://input' );
$input = json_decode( $inputJSON, true );
?>