<?php
include_once "../fachada.php";

$id = @$_GET["id"];
$id_horta = @$_GET["id_horta"];
$id_usuario = !empty($_GET['id_usuario']) ? $_GET['id_usuario'] : null;
$status = @$_GET["status"];
$titulo = @$_GET["titulo"];
$descricao = @$_GET["descricao"];


$dao = $factory->getTarefaDao();
$tarefas = $dao->buscaTodos();


if (empty($titulo) || empty($descricao)){
    header("Location: /hubhorta/tarefa/nova_tarefa.php?id_horta=$id_horta&erro=nao-preenchimento");
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


header("Location: /hubhorta/tarefas.php?id_horta=" . $id_horta . "&tarefa-inserida");
exit;

?>