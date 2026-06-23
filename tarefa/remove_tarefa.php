<?php
include_once "../fachada.php";

$id = @$_GET["id"];
$id_horta = @$_GET["id_horta"];
$dao = $factory->getTarefaDao();



$daoGerenciador = $factory->getGerenciadorDao();
$daoTarefa = $factory->getTarefaDao();


$dao->removePorId($id);

header("Location: /hubhorta/tarefas.php?id_horta=" . $id_horta . "&tarefa-removida");
exit;

?>