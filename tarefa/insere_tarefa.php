<?php
include_once "../fachada.php";

$id = @$_GET["id"];
$id_horta = @$_GET["id_horta"];
$id_usuario = @$_GET["id_usuario"];
$status = @$_GET["status"];
$titulo = @$_GET["titulo"];
$descricao = @$_GET["descricao"];


$dao = $factory->getTarefaDao();
$tarefas = $dao->buscaTodos();


if (empty($titulo) || empty($descricao)){
    header("Location: /hubhorta/tarefa/nova_tarefa.php?erro=nao-preenchimento");
    exit;
}

/*
if($permissao=='dono'){
    $dono = new dono(null,$nome,$login,$senha);
    $daodono = $factory->getdonoDao();
    $daodono->insere($dono);
}
*/


$tarefa = new Tarefa(null, $titulo, $descricao, $id_usuario, $id_horta, $status);
$dao->insere($tarefa);


header("Location: /hubhorta/tarefas.php");
exit;

?>