<?php

class Response {
    public static function json( $status = 200, $message = 'success', $data = null ) {
        header( 'Content-Type: application/json' );

        return json_encode( [
            'status' => $status,
            'message' => $message,
            'datetime_response' => date('Y-m-d H:i:s'),
            'data' => $data
        ], JSON_PRETTY_PRINT );

    }
}

?>