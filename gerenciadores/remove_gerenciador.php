<?php
include_once "../fachada.php";

$id = @$_GET["id"];

$daoHorta = $factory->getHortaDao();
$hortas = $daoHorta->buscaTodos();

foreach($hortas as $horta){
    if($horta->getGerenciador()->getId()==$id){
        header("Location: /hubhorta/gerenciador/gerenciadores.php?erro=impossivel-remover");
    }
}

#$gerenciadores = new Gerenciador($id,$nome,$email);

$dao = $factory->getGerenciadorDao();
$tempGerenciador = $dao -> buscaPorId($id);

$daoUsuario = $factory->getUsuarioDao();
$tempUsuario = $daoUsuario -> buscaPorLogin($tempGerenciador->getEmail());

$dao->removePorId($id);
$daoUsuario -> removePorId($tempUsuario->getId());
header("Location: gerenciadores.php?gerenciador-removido");
exit;

?>