<?php

require_once '../../../assets/configsApi/conn.php';

class Blog {
    private $db;

    public function __construct() {
        $this->db = ( new Database() )->getConnection();
    }

    public function inserirPost( $codigo, $descricao, $status, $garantia ) {
        $sql = 'INSERT INTO post (titulo, conteudo, autor, data_postagem) VALUES (?, ?, ?, ?)';
        $stmt = $this->db->prepare( $sql );
        $stmt->execute( [ $codigo, $descricao, $status, $garantia ] );
        return $ultimoID = $this->db->lastInsertId();
    }

    public function retornaPost( $postId ) {
        $sql = 'SELECT * FROM post WHERE id = :postId';
        $stmt = $this->db->prepare( $sql );
        $stmt->bindParam( ':postId', $postId, PDO::PARAM_INT );
        $stmt->execute();
        return $stmt->fetchAll( PDO::FETCH_ASSOC );
    }

    public function listarPost($pagina = 1) {
        $limit = 6;
        $offset =( $pagina - 1) * $limit;
        $sql = 'SELECT * FROM post LIMIT :limit OFFSET :offset';
        $stmt = $this->db->prepare( $sql );
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $posts =  $stmt->fetchAll( PDO::FETCH_ASSOC );

        $countSql = 'SELECT COUNT(*) as total FROM post';
        $countStmt = $this->db->query($countSql);
        $total = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];

        return [
            'posts' => $posts,      
            'total' => $total,      
            'pagina' => $pagina,    
            'limite' => $limit,    
            'totalPaginas' => ceil($total / $limit) 
        ];
    }

    public function getMaxRegistros() {
        $countSql = 'SELECT COUNT(*) as total FROM post';
        $countStmt = $this->db->query($countSql);
        return $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function listarPostTitulo($titulo) {
        $sql = 'SELECT * FROM post WHERE titulo ILIKE :titulo';
        $stmt = $this->db->prepare($sql);
        $titulo = "%$titulo%";
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);  
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function atualizarPost( $id, $titulo, $conteudo, $autor, $dataPostagem ) {
        $sql = 'UPDATE post SET titulo = ?, conteudo = ?, autor = ?, data_postagem = ? WHERE id = ?';
        $stmt = $this->db->prepare( $sql );
        $stmt->execute( [ $titulo, $conteudo, $autor, $dataPostagem, $id ] );
    }

    public function excluirPost( $id ) {
        $sql = 'DELETE FROM post WHERE id = ?';
        $stmt = $this->db->prepare( $sql );
        $stmt->execute( [ $id ] );
    }
}
?>
