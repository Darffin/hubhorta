<?php
interface UsuarioDao {

    public function insere($usuario);
    public function voluntariar($usuario, $horta);
    public function remove($usuario);
    public function removePorId($id);
    public function altera(&$usuario);
    public function buscaPorId($id);
    public function buscaPorLogin($login);
    public function buscaTodos();
}
?>