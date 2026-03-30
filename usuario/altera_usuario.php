<?php
include_once "../fachada.php";

$id = @$_GET["id"];
$login = @$_GET["login"];
$senha = @$_GET["senha"];
$nome = @$_GET["nome"];
$dao = $factory->getUsuarioDao();
$tempUsuario = $dao->buscaPorId($id);

if (empty($login) || empty($senha) || empty($nome)){
    header("Location: /web-petshop/usuario/modifica_usuario.php?erro=nao-preenchimento&id={$id}");
    exit;
}

if(($dao->buscaPorLogin($login) != null) && ($tempUsuario->getLogin() != $login)){
    header("Location: /web-petshop/usuario/modifica_usuario.php?erro=conta-ja-existente&id={$id}");
    exit;
}

$usuario = new Usuario($id,$login,md5($senha),$nome,$tempUsuario->getPermissao());

/*
if($tempUsuario->getPermissao()=='dono da horta'){
    $daodono = $factory->getdonodao();
    $tempdono = $daodono->buscaPorEmail($tempUsuario->getLogin());
    $dono = new dono($tempdono->getId(),$nome, $login, md5($senha));
    $daodono->altera($dono);
}
*/
$dao->altera($usuario);

header("Location: usuarios.php");
exit;

?>
