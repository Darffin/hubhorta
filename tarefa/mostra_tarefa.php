<?php
include_once "../fachada.php";
$tela = 'tarefas';
include "../verifica.php";

$id = @$_GET["id"];

$dao = $factory->getTarefaDao();
$tarefa = $dao->buscaPorId($id);

include_once "../layout_header.php";

if($tarefa) {
echo "<section class='container section-forms'>";
//dados da tarefa
echo "<h1> Titulo : " . $tarefa->getTitulo() . "</h1>";
echo "<p> Id : " . $tarefa->getId() . "</p>";
echo "<p> Descrição : " . $tarefa->getDescricao() . "</p>";
echo "<p> Status : " . $tarefa->getStatus() . "</p>";
// botão voltar
echo "<a href='/hubhorta/tarefas.php' class='btn btn-primary left-margin'>";
echo "Voltar";
echo "</a>";
echo "</section>";
}

include_once "../layout_footer.php";
?>
