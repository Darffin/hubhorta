<?php

include_once('GerenciadorDao.php');
include_once('PostgresDao.php');

class PostgresGerenciadorDao extends PostgresDao implements GerenciadorDao
{

    private $table_name = 'gerenciador';

    public function insere($gerenciador)
    {

        $query = "INSERT INTO " . $this->table_name .
            " (nome, email, senha) VALUES" .
            " (:nome, :email, :senha)";

        $stmt = $this->conn->prepare($query);

        // bind values 
        $stmt->bindValue(":nome", $gerenciador->getNome());
        $stmt->bindValue(":email", $gerenciador->getEmail());
        $stmt->bindValue(":senha", md5($gerenciador->getSenha()));

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function removePorId($id)
    {
        $query = "DELETE FROM " . $this->table_name .
            " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindValue(':id', $id);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function remove($gerenciador)
    {
        return $this->removePorId($gerenciador->getId());
    }

    public function altera(&$gerenciador)
    {

        $query = "UPDATE " . $this->table_name .
            " SET nome = :nome, email = :email, senha = :senha" .
            " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindValue(":nome", $gerenciador->getNome());
        $stmt->bindValue(":email", $gerenciador->getEmail());
        $stmt->bindValue(':id', $gerenciador->getId());
        $stmt->bindValue(":senha", $gerenciador->getSenha());

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function buscaPorId($id)
    {

        $gerenciador = null;

        $query = "SELECT
                    id, nome, email, senha
                FROM
                    " . $this->table_name . "
                WHERE
                    id = ?
                LIMIT
                    1 OFFSET 0";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $gerenciador = new Gerenciador($row['id'], $row['nome'], $row['email'], $row['senha']);
        }
        return $gerenciador;
    }

    public function buscaPorEmail($email)
    {

        $gerenciador = null;

        $query = "SELECT
                    id, nome, email, senha
                FROM
                    " . $this->table_name . "
                WHERE
                    email = ?
                LIMIT
                    1 OFFSET 0";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $gerenciador = new Gerenciador($row['id'], $row['nome'], $row['email'], $row['senha']);
        }
        return $gerenciador;
    }


    public function buscaTodos()
    {

        $gerenciador = array();

        $query = "SELECT
                    id, nome, email, senha
                FROM
                    " . $this->table_name .
            " ORDER BY id ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $gerenciador[] = new Gerenciador($id, $nome, $email, $senha);
        }

        return $gerenciador;
    }

    public function buscaPorNomeCom($palavra)
    {
        $gerenciadores = array();

        $query = "SELECT
                    id, nome, email, senha
              FROM
                " . $this->table_name . " 
              WHERE 
                nome LIKE ?
              ORDER BY 
                id ASC";

        $stmt = $this->conn->prepare($query);
        $parametro = "%" . $palavra . "%";
        $stmt->bindValue(1, $parametro);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $gerenciadores[] = new Gerenciador($id, $nome, $email, $senha);
        }

        return $gerenciadores;
    }

    // Hora de tentar paginar

public function buscaTodosPaginado($inicio,$quantos) {
    $gerenciadores = array();

    $query = "SELECT
                    id, nome, email, senha
              FROM
                " . $this->table_name . " 
                ORDER BY id ASC" .
                " LIMIT ? OFFSET ?";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $quantos);
    $stmt->bindParam(2, $inicio);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $gerenciadores[] = new Gerenciador($id, $nome, $email, $senha);

    }
    
    return $gerenciadores;
}

public function buscaComNomePaginado($nome,$inicio,$quantos) {
    $gerenciadores = array();

    $query = "SELECT
                    id, nome, email, senha
              FROM
                " . $this->table_name . " 
                  WHERE UPPER(nome) LIKE ?" .
                " ORDER BY id ASC LIMIT ? OFFSET ?";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindValue(1, '%' . strtoupper($nome) . '%');
    $stmt->bindValue(2, $quantos);
    $stmt->bindValue(3, $inicio);
    $stmt->execute();

    $filter_query = $query . "LIMIT " .$quantos. " OFFSET " . $inicio . '';
    error_log("---> DAO Query : " . $filter_query);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $gerenciadores[] = new Gerenciador($id, $nome, $email, $senha);
    }
    
    return $gerenciadores;
}

public function contaComNome($nome) {
    $quantos = 0;

    $query = "SELECT COUNT(*) AS contagem FROM " . 
                $this->table_name .
                " WHERE UPPER(nome) LIKE ? ";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindValue(1, '%' . strtoupper($nome) . '%');
    
    $stmt->execute();

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $quantos = $contagem;
    }
    return $quantos;
}
}
