<?php
interface GerenciadorDao {

    public function insere($gerenciador);
    public function remove($gerenciador);
    public function removePorId($id);
    public function altera(&$gerenciador);
    public function buscaPorId($id);
    public function buscaPorEmail($email);
    public function buscaTodos();
}
?>