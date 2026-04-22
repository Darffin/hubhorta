<?php
interface HortaDao {
    public function insere($horta);
    public function remove($horta);
    public function removePorId($id);
    public function altera(&$horta);
    public function buscaPorId($id);
    public function buscaTodos();
}
?>