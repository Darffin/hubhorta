<?php
include_once "../fachada.php";

$id = @$_GET["id"];
$dao = $factory->getUsuarioDao();
$tempUsuario = $dao->buscaPorId($id);



$daoGerenciador = $factory->getGerenciadorDao();
$daoHorta = $factory->getHortaDao();
$Horta = $daoHorta->buscaTodos();
if($tempUsuario->getPermissao()=='gerenciador'){
    $tempGerenciador = $daoGerenciador->buscaPorEmail($tempUsuario->getLogin());
    foreach($Horta as $Horta){
        if($Horta->getGerenciador()->getId()==$tempGerenciador->getId()){
            header("Location: /web-petshop/usuario/usuarios.php?erro=impossivel-remover");
        }
    }
    $daoGerenciador->removePorId($tempGerenciador->getId());
}

$dao->removePorId($id);

header("Location: usuarios.php?usuario-removido");
exit;

?>