<?php
include_once "../fachada.php";

$id = @$_GET["id"];
$dao = $factory->getTarefaDao();



$daoGerenciador = $factory->getGerenciadorDao();
$daoTarefa = $factory->getTarefaDao();


$dao->removePorId($id);

header("Location: /hubhorta/tarefas.php?tarefa-removida");
exit;

?>