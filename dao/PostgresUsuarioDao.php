<?php

include_once('UsuarioDao.php');
include_once('PostgresDao.php');

class PostgresUsuarioDao extends PostgresDao implements UsuarioDao {

    private $table_name = 'usuario';
    
    public function insere($usuario) {

        $query = "INSERT INTO " . $this->table_name . 
        " (login, senha, nome, permissao) VALUES" .
        " (:login, :senha, :nome, :permissao)";

        $stmt = $this->conn->prepare($query);

        // bind values 
        $stmt->bindValue(":login", $usuario->getLogin());
        $stmt->bindValue(":senha", md5($usuario->getSenha()));
        $stmt->bindValue(":nome", $usuario->getNome());
        $stmt->bindValue(":permissao", $usuario->getPermissao());

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

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

    public function remove($usuario) {
        return $this->removePorId($usuario->getId());
    }

    public function altera(&$usuario) {

        $query = "UPDATE " . $this->table_name . 
        " SET login = :login, senha = :senha, nome = :nome, permissao = :permissao" .
        " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindValue(":login", $usuario->getLogin());
        $stmt->bindValue(":senha", $usuario->getSenha());
        $stmt->bindValue(":nome", $usuario->getNome());
        $stmt->bindValue(':id', $usuario->getId());
        $stmt->bindValue(':permissao', $usuario->getPermissao());

        // execute the query
        if($stmt->execute()){
            return true;
        }    

        return false;
    }

    public function buscaPorId($id) {
        
        $usuario = null;

        $query = "SELECT
                    id, login, nome, senha, permissao
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
            $usuario = new Usuario($row['id'],$row['login'], $row['senha'], $row['nome'], $row['permissao']);
        } 
     
        return $usuario;
    }

    public function buscaPorLogin($login) {

        $usuario = null;

        $query = "SELECT
                    id, login, nome, senha, permissao
                FROM
                    " . $this->table_name . "
                WHERE
                    login = ?
                LIMIT
                    1 OFFSET 0";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindValue(1, $login);
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $usuario = new Usuario($row['id'],$row['login'], $row['senha'], $row['nome'], $row['permissao']);
        } 
     
        return $usuario;
    }

    /*
    public function buscaTodos() {

        $query = "SELECT
                    id, login, senha, nome
                FROM
                    " . $this->table_name . 
                    " ORDER BY id ASC";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
     
        return $stmt;
    }
    */

    public function buscaTodos() {

        $usuarios = array();

        $query = "SELECT
                    id, login, senha, nome, permissao
                FROM
                    " . $this->table_name . 
                    " ORDER BY id ASC";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $usuarios[] = new Usuario($id,$login,$senha,$nome,$permissao);
        }
        
        return $usuarios;
    }

    public function buscaPorNomeCom($palavra){
    $usuarios = array();

    $query = "SELECT
                    id, login, senha, nome, permissao
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

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $usuarios[] = new Usuario($id,$login,$senha,$nome,$permissao);
        }

    return $usuarios;
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

public function buscaComNomePaginado($nome,$inicio,$quantos) {
    $usuarios = array();

    $query = "SELECT
                    id, login, senha, nome, permissao
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
        $usuarios[] = new Usuario($id,$login,$senha,$nome,$permissao);
    }
    
    return $usuarios;
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

?>