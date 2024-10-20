<?php

class Database {
    private $host = 'localhost';
    private $dbname = 'blog';
    private $username = 'postgres';
    private $password = 'mysecretpassword';
    private $port = '5432';

    public function getConnection() {
        try {
            $pdo = new PDO( "pgsql:host=$this->host;port=$this->port;dbname=$this->dbname", $this->username, $this->password );
            $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            return $pdo;
        } catch ( PDOException $err ) {
            echo 'Erro na conexão: ' . $err->getMessage();
            die();
        }
    }
}

?>
