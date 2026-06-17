<?php
interface TarefaDao {
    public function insere($tarefa);
    public function remove($tarefa);
    public function removePorId($id);
    public function altera(&$tarefa);
    public function buscaPorId($id);
    public function buscaTodos();
}
?>