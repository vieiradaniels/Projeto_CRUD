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
    public function criar($idusu, $data, $titulo, $noticia)
    {
        $query = "INSERT INTO " . $this->table_name . " (idusu, data, titulo, noticia) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idusu, $data, $titulo, $noticia]);
        return $stmt;
    }

    // Atualiza uma notícia existente
    public function atualizar($idnot, $titulo, $noticia)
    {
        $query = "UPDATE " . $this->table_name . " SET titulo = ?, noticia = ? WHERE idnot = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$titulo, $noticia, $idnot]);
    }

    // Deleta uma notícia pelo seu ID
    public function deletar($idnot)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE idnot = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idnot]);
        return $stmt;
    }

    // Obtém todas as notícias
    public function ler($search = '', $order_by = '') {
        $query = "SELECT noticias.*, usuarios.nome AS nome_usuario FROM noticias 
                  JOIN usuarios ON noticias.idusu = usuarios.id";
        $conditions = [];
        $params = [];
        if ($search) {
            $conditions[] = "(noticias.titulo LIKE :search OR noticias.noticia LIKE :search OR usuarios.nome LIKE :search OR usuarios.email LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }
        if ($order_by === 'titulo') {
            $query .= " ORDER BY noticias.titulo";
        } elseif ($order_by === 'data') {
            $query .= " ORDER BY noticias.data";
        } elseif ($order_by === 'nome_usuario') {
            $query .= " ORDER BY usuarios.nome";
        }
        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }    

    // Obtém uma notícia pelo seu ID
    public function lerPorId($idnot)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idnot = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idnot]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>
