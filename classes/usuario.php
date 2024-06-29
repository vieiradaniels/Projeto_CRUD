<?php

class Usuario
{
    private $conn;
    private $table_name = "usuarios"; // nome da tabela
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function registrar($nome, $sexo, $fone, $email, $senha)
    {
        $query = "INSERT INTO " . $this->table_name . " (nome, sexo, fone, email, senha) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($senha, PASSWORD_BCRYPT);
        $stmt->execute([$nome, $sexo, $fone, $email, $hashed_password]);
        return $stmt;
    }
    public function login($email, $senha)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }
        return false;
    }
    public function atualizar($id, $nome, $sexo, $fone, $email)
    {
        $query = "UPDATE " . $this->table_name . " SET nome=?, sexo=?, fone=?, email=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nome, $sexo, $fone, $email, $id]);
    }
    public function deletar($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt;
    }
    public function ler($search = '', $order_by = '')
    {
        $query = "SELECT * FROM " . $this->table_name;
        $conditions = [];
        $params = [];

        if ($search) {
            $conditions[] = "(nome LIKE :search OR email LIKE :search OR sexo LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }

        if ($order_by === 'nome') {
            $query .= " ORDER BY nome";
        } elseif ($order_by === 'sexo') {
            $query .= " ORDER BY sexo";
        }

        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(' OR ', $conditions);
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        return $stmt;
    }

    public function lerPorId($id)
    {
        $query = "SELECT * FROM " . $this->table_name .
            " WHERE id =?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Gera um código de verificação e o salva no banco de dados
    public function gerarCodigoVerificacao($email)
    {
        // Gera um código de verificação aleatório de 10 caracteres
        $codigo = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 10);

        // Define a consulta SQL para atualizar o código de verificação para o email fornecido
        $query = "UPDATE " . $this->table_name . " SET codigo_verificacao = ? WHERE email = ?";

        // Prepara a consulta
        $stmt = $this->conn->prepare($query);

        // Executa a consulta com os parâmetros fornecidos
        $stmt->execute([$codigo, $email]);

        // Retorna o código gerado se a atualização foi bem-sucedida, caso contrário, retorna false
        return ($stmt->rowCount() > 0) ? $codigo : false;
    }

    // Verifica se o código de verificação é válido
    public function verificarCodigo($codigo)
    {
        // Define a consulta SQL para selecionar a entrada com o código de verificação fornecido
        $query = "SELECT * FROM " . $this->table_name . " WHERE codigo_verificacao = ?";

        // Prepara a consulta
        $stmt = $this->conn->prepare($query);

        // Executa a consulta com o parâmetro fornecido
        $stmt->execute([$codigo]);

        // Retorna a linha correspondente como um array associativo, ou false se não encontrado
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Redefine a senha do usuário e remove o código de verificação
    public function redefinirSenha($codigo, $senha)
    {
        // Define a consulta SQL para atualizar a senha e remover o código de verificação
        $query = "UPDATE " . $this->table_name . " SET senha = ?, codigo_verificacao = NULL WHERE codigo_verificacao = ?";

        // Prepara a consulta
        $stmt = $this->conn->prepare($query);

        // Hash a nova senha usando bcrypt
        $hashed_password = password_hash($senha, PASSWORD_BCRYPT);

        // Executa a consulta com a senha hash e o código de verificação fornecidos
        $stmt->execute([$hashed_password, $codigo]);

        // Retorna true se alguma linha foi afetada, indicando que a senha foi redefinida
        return $stmt->rowCount() > 0;
    }

}