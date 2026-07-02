<?php

include_once('EstoqueDao.php');
include_once('PostgresDao.php');

class PostgresEstoqueDao extends PostgresDao implements EstoqueDao {

    private $table_name = 'estoque';
    
    public function insere($estoque) {

        $query = "INSERT INTO " . $this->table_name . 
        " ( quantidade, id_horta, nome_item) VALUES" .
        " ( :quantidade, :id_horta, :nome_item)";

        $stmt = $this->conn->prepare($query);

        // bind values 
        $stmt->bindValue(":quantidade", $estoque->getQuantidade());
        $stmt->bindValue(":id_horta", $estoque->getIdHorta());
        $stmt->bindValue(":nome_item", $estoque->getNomeItem());

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

    public function buscaEstoqueDeHorta($id_horta) {

    $estoques = array();

        $query = "SELECT
                    id, quantidade, id_horta, nome_item
                FROM
                    " . $this->table_name . "
                WHERE
                    id_horta = ?
                LIMIT";

    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(1, $id_horta);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $estoque = new Estoque(
            $row['id'],
            $row['quantidade'],
            $row['id_horta'],
            $row['nome_item']
        );

        $estoques[] = $estoque;
    }

    return $estoques;
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

    public function remove($estoque) {
        return $this->removePorId($estoque->getId());
    }

    public function altera(&$estoque) {

        $query = "UPDATE " . $this->table_name . 
        " SET quantidade = :quantidade, id_horta = :id_horta, nome_item = :nome_item" .
        " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindValue(":quantidade", $estoque->getQuantidade());
        $stmt->bindValue(":id_horta", $estoque->getIdHorta());
        $stmt->bindValue(":nome_item", $estoque->getNomeItem());
        $stmt->bindValue(':id', $estoque->getId());

        // execute the query
        if($stmt->execute()){
            return true;
        }    

        return false;
    }


    public function buscaPorId($id) {
        
        $estoque = null;

        $query = "SELECT
                    id, quantidade, id_horta, nome_item
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
            $estoque = new Estoque($row['id'],$row['quantidade'], $row['id_horta'], $row['nome_item']);
        } 
     
        return $estoque;
    }

    public function buscaTodos() {

        $estoques = array();

        $query = "SELECT
                    id, quantidade, id_horta, nome_item
                FROM
                    " . $this->table_name . 
                    " ORDER BY id ASC";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $estoques[] = new Estoque($id,$quantidade,$id_horta,$nome_item);
        }
        
        return $estoques;
    }


//  paginar


public function buscaTodosPaginado($inicio,$quantos) {
    $estoques = array();

    $query = "SELECT
                    id, quantidade, id_horta, nome_item
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
        $estoques[] = new Estoque($id,$quantidade,$id_horta,$nome_item);

    }
    
    return $estoques;
}

public function buscaPorHortaPaginado($id_horta,$inicio,$quantos) {
    $estoques = array();

    $query = "SELECT
                    id, quantidade, id_horta, nome_item
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
        $estoques[] = new Estoque($id,$quantidade,$id_horta,$nome_item);
    }
    
    return $estoques;
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

}


?>