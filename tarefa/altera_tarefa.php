<?php
include_once "../fachada.php";

$id = $_POST["id_tarefa"] ?? null;
$status = $_POST["status"] ?? null;
$id_horta = @$_GET["id_horta"];
$id_usuario = @$_GET["id_usuario"];
$titulo = @$_GET["titulo"];
$descricao = @$_GET["descricao"];
$dao = $factory->getTarefaDao();
$tempTarefa = $dao->buscaPorId($id);

if ((empty($titulo) || empty($descricao)) && $tempTarefa == null){
    header("Location: /hubhorta/tarefa/modifica_tarefa.php?erro=nao-preenchimento&id={$id}");
    exit;
}

if($tempTarefa != null){
$tempTarefa->setStatus($status);
$dao->altera($tempTarefa);
} else {
    $tarefa = new Tarefa($id, $titulo, $descricao, $id_usuario, $id_horta, $status);
    $dao->altera($tarefa);
}

header("Location: /hubhorta/tarefas.php");
exit;

?>
