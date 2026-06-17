<?php
include_once "../fachada.php";

$id = @$_GET["id"];
$id_horta = @$_GET["id_horta"];
$id_usuario = @$_GET["id_usuario"];
$status = @$_GET["status"];
$titulo = @$_GET["titulo"];
$descricao = @$_GET["descricao"];
$dao = $factory->getTarefaDao();
$tempTarefa = $dao->buscaPorId($id);

if (empty($titulo) || empty($descricao)){
    header("Location: /hubhorta/tarefa/modifica_tarefa.php?erro=nao-preenchimento&id={$id}");
    exit;
}

$tarefa = new Tarefa($id, $titulo, $descricao, $id_usuario, $id_horta, $status);

$dao->altera($tarefa);

header("Location: /hubhorta/tarefas.php");
exit;

?>
