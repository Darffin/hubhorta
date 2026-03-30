<?php
include_once "../fachada.php";

$id = @$_GET["id"];
$dao = $factory->getUsuarioDao();
$tempUsuario = $dao->buscaPorId($id);


/*
$daoDono = $factory->getDonoDao();
$daoHorta = $factory->getHortaDao();
$Horta = $daoHorta->buscaTodos();
if($tempUsuario->getPermissao()=='Dono'){
    $tempDono = $daoDono->buscaPorEmail($tempUsuario->getLogin());
    foreach($Horta as $Horta){
        if($Horta->getDono()->getId()==$tempDono->getId()){
            header("Location: /web-petshop/usuario/usuarios.php?erro=impossivel-remover");
        }
    }
    $daoDono->removePorId($tempDono->getId());
}
*/

$dao->removePorId($id);

header("Location: usuarios.php?usuario-removido");
exit;

?>