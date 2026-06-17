<?php

include_once('TarefaDao.php');
include_once('PostgresDao.php');

class PostgresTarefaDao extends PostgresDao implements TarefaDao {

    private $table_name = 'tarefa';
    
    public function insere($tarefa) {

        $query = "INSERT INTO " . $this->table_name . 
        " (titulo, descricao, id_usuario, id_horta, status) VALUES" .
        " (:titulo, :descricao, :id_usuario, :id_horta, :status)";

        $stmt = $this->conn->prepare($query);

        // bind values 
        $stmt->bindValue(":titulo", $tarefa->getTitulo());
        $stmt->bindValue(":descricao", $tarefa->getDescricao());
        $stmt->bindValue(":id_usuario", $tarefa->getIdUsuario());
        $stmt->bindValue(":id_horta", $tarefa->getIdHorta());
        $stmt->bindValue(":status", $tarefa->getStatus());

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

    public function buscaTarefasDeUmUsuario($id_usuario) {

    $tarefas = array();

    $query = "SELECT t.*
              FROM tarefa t
              INNER JOIN usuario u
                  ON t.id_usuario = u.id
              WHERE t.id_usuario = ?
              ORDER BY t.id ASC";

    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(1, $id_usuario);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $tarefa = new Tarefa(
            $row['id'],
            $row['titulo'],
            $row['descricao'],
            $row['id_usuario'],
            $row['id_horta'],
            $row['status']
        );

        $tarefas[] = $tarefa;
    }

    return $tarefas;
}

    public function removePorId($id) {
        $query = "DELETE FROM " . $this->table_name . 
        " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindValue(':id', $id);

        // execute the query
        if($stmt->execute()){
            return true;
        }    

        return false;
    }

    public function remove($tarefa) {
        return $this->removePorId($tarefa->getId());
    }

    public function altera(&$tarefa) {

        $query = "UPDATE " . $this->table_name . 
        " SET titulo = :titulo, descricao = :descricao, id_usuario = :id_usuario, id_horta = :id_horta, status = :status" .
        " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindValue(":titulo", $tarefa->getTitulo());
        $stmt->bindValue(":descricao", $tarefa->getDescricao());
        $stmt->bindValue(":id_usuario", $tarefa->getIdUsuario());
        $stmt->bindValue(":id_horta", $tarefa->getIdHorta());
        $stmt->bindValue(":status", $tarefa->getStatus());
        $stmt->bindValue(':id', $tarefa->getId());

        // execute the query
        if($stmt->execute()){
            return true;
        }    

        return false;
    }

    public function buscaPorId($id) {
        
        $tarefa = null;

        $query = "SELECT
                    id, titulo, descricao, id_usuario, id_horta, status
                FROM
                    " . $this->table_name . "
                WHERE
                    id = ?
                LIMIT
                    1 OFFSET 0";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindValue(1, $id);
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $tarefa = new Tarefa($row['id'],$row['titulo'], $row['descricao'], $row['id_usuario'], $row['id_horta'], $row['status']);
        } 
     
        return $tarefa;
    }

    public function buscaPorHorta($id_horta) {

        $tarefa = null;

        $query = "SELECT
                    id, titulo, descricao, id_usuario, id_horta, status
                FROM
                    " . $this->table_name . "
                WHERE
                    id_horta = ?
                LIMIT
                    1 OFFSET 0";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindValue(1, $id_horta);
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $tarefa = new Tarefa($row['id'],$row['titulo'], $row['descricao'], $row['id_usuario'], $row['id_horta'], $row['status']);
        } 
     
        return $tarefa;
    }

    public function buscaTodos() {

        $tarefas = array();

        $query = "SELECT
                    id, titulo, descricao, id_usuario, id_horta, status
                FROM
                    " . $this->table_name . 
                    " ORDER BY id ASC";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $tarefas[] = new Tarefa($id,$titulo,$descricao,$id_usuario,$id_horta,$status);
        }
        
        return $tarefas;
    }

    public function buscaPorTitulo($titulo){
    $tarefas = array();

    $query = "SELECT
                    id, titulo, descricao, id_usuario, id_horta, status
              FROM
                " . $this->table_name . " 
              WHERE 
                titulo LIKE ?
              ORDER BY 
                id ASC";

    $stmt = $this->conn->prepare($query);
    $parametro = "%" . $titulo . "%";
    $stmt->bindValue(1, $parametro);
    $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $tarefas[] = new Tarefa($id,$titulo,$descricao,$id_usuario,$id_horta,$status);
        }

    return $tarefas;
}


//  paginar


public function buscaTodosPaginado($inicio,$quantos) {
    $usuarios = array();

    $query = "SELECT
                    id, login, senha, nome, permissao
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
        $usuarios[] = new Usuario($id,$login,$senha,$nome,$permissao);

    }
    
    return $usuarios;
}

public function buscaPorHortaPaginado($id_horta,$inicio,$quantos) {
    $tarefas = array();

    $query = "SELECT
                    id, titulo, descricao, id_usuario, id_horta, status
              FROM
                " . $this->table_name . "
                  WHERE id_horta = ?" .
                " ORDER BY id ASC LIMIT ? OFFSET ?";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindValue(1, $id_horta);
    $stmt->bindValue(2, $quantos);
    $stmt->bindValue(3, $inicio);
    $stmt->execute();

    $filter_query = $query . "LIMIT " .$quantos. " OFFSET " . $inicio . '';
    error_log("---> DAO Query : " . $filter_query);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $tarefas[] = new Tarefa($id,$titulo,$descricao,$id_usuario,$id_horta,$status);
    }
    
    return $tarefas;
}

public function contaPorHorta($id_horta) {
    $quantos = 0;

    $query = "SELECT COUNT(*) AS contagem FROM " . 
                $this->table_name .
                " WHERE id_horta = ?";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindValue(1, $id_horta);
    
    $stmt->execute();

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $quantos = $contagem;
    }
    return $quantos;
}

public function buscaPorUsuarioPaginado($id_usuario,$inicio,$quantos) {
    $tarefas = array();

    $query = "SELECT
                    id, titulo, descricao, id_usuario, id_horta, status
              FROM
                " . $this->table_name . "
                  WHERE id_usuario = ?" .
                " ORDER BY id ASC LIMIT ? OFFSET ?";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindValue(1, $id_usuario);
    $stmt->bindValue(2, $quantos);
    $stmt->bindValue(3, $inicio);
    $stmt->execute();

    $filter_query = $query . "LIMIT " .$quantos. " OFFSET " . $inicio . '';
    error_log("---> DAO Query : " . $filter_query);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $tarefas[] = new Tarefa($id,$titulo,$descricao,$id_usuario,$id_horta,$status);
    }
    
    return $tarefas;
}

public function contaPorUsuario($id_usuario) {
    $quantos = 0;

    $query = "SELECT COUNT(*) AS contagem FROM " . 
                $this->table_name .
                " WHERE id_usuario = ?";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindValue(1, $id_usuario);
    
    $stmt->execute();

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $quantos = $contagem;
    }
    return $quantos;
}

public function buscaPorGerenciadorPaginado($id_usuario,$inicio,$quantos) {
    $tarefas = array();

    $query = "SELECT
                    id, titulo, descricao, id_usuario, id_horta, status
              FROM
                " . $this->table_name . "
                  WHERE id_usuario = ?" .
                " ORDER BY id ASC LIMIT ? OFFSET ?";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindValue(1, $id_usuario);
    $stmt->bindValue(2, $quantos);
    $stmt->bindValue(3, $inicio);
    $stmt->execute();

    $filter_query = $query . "LIMIT " .$quantos. " OFFSET " . $inicio . '';
    error_log("---> DAO Query : " . $filter_query);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $tarefas[] = new Tarefa($id,$titulo,$descricao,$id_usuario,$id_horta,$status);
    }
    
    return $tarefas;
}

public function contaPorGerenciador($id_usuario) {
    $quantos = 0;

    $query = "SELECT COUNT(*) AS contagem FROM " . 
                $this->table_name .
                " WHERE id_usuario = ?";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindValue(1, $id_usuario);
    
    $stmt->execute();

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $quantos = $contagem;
    }
    return $quantos;
}

}

?>