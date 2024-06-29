<?php

class Noticia
{
    private $conn;
    private $table_name = "noticias"; // nome da tabela de notícias

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Cria uma nova notícia
    public function criar($idusu, $data, $titulo, $conteudo) {
        $query = "INSERT INTO noticias (idusu, data, titulo, noticia) VALUES (:idusu, :data, :titulo, :conteudo)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idusu', $idusu);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':conteudo', $conteudo);
        $stmt->execute();
    }

    // Atualiza uma notícia existente
    public function atualizar($idnot, $titulo, $conteudo) {
        $query = "UPDATE noticias SET titulo = :titulo, noticia = :conteudo WHERE idnot = :idnot";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idnot', $idnot);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':conteudo', $conteudo);
        $stmt->execute();
    }

    // Deleta uma notícia pelo seu ID
    public function deletar($idnot) {
        $query = "DELETE FROM noticias WHERE idnot = :idnot";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idnot', $idnot);
        $stmt->execute();
    }

    public function ler($search = '', $order_by = '')
{
    $query = "SELECT noticias.*, usuarios.nome AS nome_usuario FROM noticias 
              JOIN usuarios ON noticias.idusu = usuarios.id";
    $conditions = [];
    $params = [];

    if ($search) {
        $conditions[] = "(noticias.titulo LIKE :search OR noticias.data LIKE :search)";
        $params[':search'] = '%' . $search . '%';
    }

    if (count($conditions) > 0) {
        $query .= " WHERE " . implode(' OR ', $conditions);
    }

    if ($order_by === 'titulo') {
        $query .= " ORDER BY noticias.titulo";
    } elseif ($order_by === 'data') {
        $query .= " ORDER BY noticias.data";
    }

    $stmt = $this->conn->prepare($query);
    $stmt->execute($params);

    return $stmt;
}

    // Obtém uma notícia pelo seu ID
    public function lerPorId($idusu) {
        $query = "SELECT * FROM noticias WHERE idusu = :idusu";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idusu', $idusu);
        $stmt->execute();
        return $stmt;
    }

    public function lerPorIdNot($idnot) {
        $query = "SELECT * FROM noticias WHERE idnot = :idnot";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idnot', $idnot);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function lerPaginado($limit, $offset) {
        $query = "SELECT * FROM noticias LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function contarNoticias() {
        $query = "SELECT COUNT(*) as total FROM noticias";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}

?>
