<?php

include_once('HortaDao.php');
include_once('PostgresDao.php');

class PostgresHortaDao extends PostgresDao implements HortaDao
{

    private $table_name = 'horta';

    public function insere($horta)
    {

        $query = "INSERT INTO " . $this->table_name .
            " (nome, latitude, longitude, id_gerenciador) VALUES" .
            " (:nome, :latitude, :longitude, :id_gerenciador)";

        $stmt = $this->conn->prepare($query);

        // bind values 
        $stmt->bindValue(":nome", $horta->getNome());
        $stmt->bindValue(":latitude", $horta->getLatitude());
        $stmt->bindValue(":longitude", $horta->getLongitude());
        $stmt->bindValue(":id_gerenciador", $horta->getGerenciador()->getId());
        if ($horta->getGerenciador()) {
            $stmt->bindValue(":id_gerenciador", $horta->getGerenciador()->getId());
        } else {
            $stmt->bindValue(":id_gerenciador", null);
        }
        $stmt->bindValue(":imagem", $horta->getImagem());

        if ($stmt->execute()) {
            return true;
        } else { // !!!
            return false;
        }
    }

    public function removePorId($id)
    {
        $horta = $this->buscaPorId($id);

        $query = "DELETE FROM " . $this->table_name .
            " WHERE id = :id";

        $nome = $horta->getImagem();
        if ($nome) {
            $nome_temporario = "../images/uploads/" . $nome;
            unlink($nome_temporario) or die("Deu zebra! Não pude deletar o arquivo!");
        }

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindValue(':id', $id);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function remove($horta)
    {
        return $this->removePorId($horta->getId());
    }

    public function altera(&$horta)
    {

        $query = "UPDATE " . $this->table_name .
            " SET nome = :nome, latitude = :latitude, longitude = :longitude, id_gerenciador = :id_gerenciador, imagem = :imagem" .
            " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // bind parameters
        $stmt->bindValue(":nome", $horta->getNome());
        $stmt->bindValue(":latitude", $horta->getLatitude());
        $stmt->bindValue(":longitude", $horta->getLongitude());
        $stmt->bindValue(':id', $horta->getId());
        if ($horta->getGerenciador()) {
            $stmt->bindValue(":id_gerenciador", $horta->getGerenciador()->getId());
        } else {
            $stmt->bindValue(":id_gerenciador", null);
        }
        $stmt->bindValue(':imagem', $horta->getImagem());

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function buscaPorId($id)
    {
        $horta = null;

        $query = "SELECT
                    horta.id as id, horta.nome as nome, 
                    latitude, longitude, gerenciador.nome as gerenciador_horta, id_gerenciador, imagem
                FROM
                    " . $this->table_name . "
                JOIN gerenciador on gerenciador.id = id_gerenciador
                WHERE
                    horta.id = ?
                LIMIT
                    1 OFFSET 0";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            extract($row);
            $horta = new Horta($id, $nome, $latitude, $longitude, $gerenciador_horta, $imagem);
            $gerenciador = Gerenciador::withId($id_gerenciador);
            $gerenciador->setNome($gerenciador_horta);
            $horta->setGerenciador($gerenciador);
        }

        return $horta;
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

    public function buscaTodos()
    {
        $query = "SELECT
                    horta.id as id, horta.nome as nome, 
                    latitude, longitude, gerenciador.nome as gerenciador_horta, id_gerenciador, imagem
                FROM
                    " . $this->table_name .
            " JOIN gerenciador on gerenciador.id = id_gerenciador" .
            " ORDER BY id ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $hortas = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $horta = new Horta($id, $nome, $latitude, $longitude, $gerenciador_horta, $imagem);
            $gerenciador = Gerenciador::withId($id_gerenciador);
            $gerenciador->setNome($gerenciador_horta);
            $horta->setGerenciador($gerenciador);
            $hortas[] = $horta;
        }
        return $hortas;
    }

        public function buscaTodosPorGerenciador($id)
    {
        $query = "SELECT
                    horta.id as id, horta.nome as nome, 
                    latitude, longitude, gerenciador.nome as gerenciador_horta, id_gerenciador, imagem
                FROM
                    " . $this->table_name .
            " WHERE gerenciador on gerenciador.id = ?" .
            " ORDER BY id ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $hortas = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $horta = new Horta($id, $nome, $latitude, $longitude, $gerenciador_horta, $imagem);
            $gerenciador = Gerenciador::withId($id_gerenciador);
            $gerenciador->setNome($gerenciador_horta);
            $horta->setGerenciador($gerenciador);
            $hortas[] = $horta;
        }
        return $hortas;
    }

    public function buscaPorNomeCom($palavra){
    $hortas = array();

    $query = "SELECT
                h.id as id, h.nome as nome, 
                h.valor, h.quantidade, 
                g.nome as gerenciador_horta, h.id_gerenciador, h.imagem
              FROM
                " . $this->table_name . " h
              JOIN 
                gerenciador g ON g.id = h.id_gerenciador 
              WHERE 
                h.nome LIKE ?
              ORDER BY 
                h.id ASC";

    $stmt = $this->conn->prepare($query);
    $parametro = "%" . $palavra . "%";
    $stmt->bindValue(1, $parametro);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $horta = new Horta($id, $nome, $latitude, $longitude, $gerenciador_horta, $imagem);
        $gerenciador = Gerenciador::withId($id_gerenciador);
        $gerenciador->setNome($gerenciador_horta);
        $horta->setGerenciador($gerenciador);

        $hortas[] = $horta;
    }

    return $hortas;
}

// Hora de tentar paginar

public function buscaTodosPaginado($inicio,$quantos) {
    $hortas = array();

    $query = "SELECT
                h.id as id, h.nome as nome, 
                h.latitude, h.longitude, 
                g.nome as gerenciador_horta, h.id_gerenciador, h.imagem
              FROM
                " . $this->table_name . " p
              JOIN 
                fornecedor f ON f.id = p.id_fornecedor
                ORDER BY id ASC" .
                " LIMIT ? OFFSET ?";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $quantos);
    $stmt->bindParam(2, $inicio);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $horta = new Horta($id, $nome, $latitude, $longitude, $gerenciador_horta, $imagem);
        $gerenciador = Gerenciador::withId($id_gerenciador);
        $gerenciador->setNome($gerenciador_horta);
        $horta->setGerenciador($gerenciador);

        $hortas[] = $horta;
    }
    
    return $hortas;
}

public function buscaComNomePaginado($nome,$inicio,$quantos) {
    $hortas = array();

    $query = "SELECT
                h.id as id, h.nome as nome, 
                h.latitude, h.longitude, 
                g.nome as gerenciador_horta, h.id_gerenciador, h.imagem
              FROM
                " . $this->table_name . " h
              JOIN 
                gerenciador g ON g.id = h.id_gerenciador
                  WHERE UPPER(h.nome) LIKE ? AND 
              h.quantidade > 0" .
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
        $horta = new Horta($id, $nome, $latitude, $longitude, $gerenciador_horta, $imagem);
        $gerenciador = Gerenciador::withId($id_gerenciador);
        $gerenciador->setNome($gerenciador_horta);
        $horta->setGerenciador($gerenciador);

        $hortas[] = $horta;
    }
    return $hortas;
}

public function contaComNome($nome) {
    $quantos = 0;

    $query = "SELECT COUNT(*) AS contagem FROM " . 
                $this->table_name . " 
                WHERE UPPER(nome) LIKE ? AND quantidade > 0";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindValue(1, '%' . strtoupper($nome) . '%');
    
    $stmt->execute();

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $quantos = $contagem;
    }
    return $quantos;
}

public function buscaComNomePaginadoAdmin($nome,$inicio,$quantos) {
    $hortas = array();

    $query = "SELECT
                h.id as id, h.nome as nome, 
                h.latitude, h.longitude, 
                g.nome as gerenciador_horta, h.id_gerenciador, h.imagem
              FROM
                " . $this->table_name . " h
              JOIN 
                gerenciador g ON g.id = h.id_gerenciador
                  WHERE UPPER(h.nome) LIKE ?" .
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
        $horta = new Horta($id, $nome, $latitude, $longitude, $gerenciador_horta, $imagem);
        $gerenciador = Gerenciador::withId($id_gerenciador);
        $gerenciador->setNome($gerenciador_horta);
        $horta->setGerenciador($gerenciador);

        $hortas[] = $horta;
    }
    return $hortas;
}

public function contaComNomeAdmin($nome) {
    $quantos = 0;

    $query = "SELECT COUNT(*) AS contagem FROM " . 
                $this->table_name . " 
                WHERE UPPER(nome) LIKE ? ";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindValue(1, '%' . strtoupper($nome) . '%');
    
    $stmt->execute();

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $quantos = $contagem;
    }
    return $quantos;
}

public function buscaComNomePaginadoGerenciador($nome,$inicio,$quantos,$login) {
    $produtos = array();

    $query = "SELECT
                h.id as id, h.nome as nome, 
                h.latitude, h.longitude, 
                g.nome as gerenciador_horta, h.id_gerenciador, h.imagem
              FROM
                " . $this->table_name . " h
              JOIN 
                gerenciador g ON g.id = h.id_gerenciador
                  WHERE UPPER(h.nome) LIKE ? AND g.email LIKE ?" .
                " ORDER BY id ASC LIMIT ? OFFSET ?";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindValue(1, '%' . strtoupper($nome) . '%');
    $stmt->bindValue(2, $login);
    $stmt->bindValue(3, $quantos);
    $stmt->bindValue(4, $inicio);
    $stmt->execute();

    $filter_query = $query . "LIMIT " .$quantos. " OFFSET " . $inicio . '';
    error_log("---> DAO Query : " . $filter_query);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $horta = new Horta($id, $nome, $latitude, $longitude, $gerenciador_horta, $imagem);
        $gerenciador = Gerenciador::withId($id_gerenciador);
        $gerenciador->setNome($gerenciador_horta);
        $horta->setGerenciador($gerenciador);

        $hortas[] = $horta;
    }
    return $hortas;
}

public function contaComNomeGerenciador($nome,$login) {
    $quantos = 0;

    $query = "SELECT COUNT(*) AS contagem FROM " . 
                $this->table_name . " p
              JOIN 
                fornecedor f ON f.id = p.id_fornecedor
                WHERE UPPER(p.nome) LIKE ? AND f.email LIKE ?";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindValue(1, '%' . strtoupper($nome) . '%');
    $stmt->bindValue(2, $login);
    $stmt->execute();

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $quantos = $contagem;
    }
    return $quantos;
}
}
