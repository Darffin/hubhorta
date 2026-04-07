<?php
include_once "../fachada.php";

$id = @$_GET["id"];
$nome = @$_GET["nome"];
$email = @$_GET["email"];
$senha = @$_GET["senha"];
$dao = $factory->getGerenciadorDao();
$daoUsuario = $factory->getUsuarioDao();
$gerenciadorAntes = $dao->buscaPorId($id);

if (empty($email) || empty($senha) || empty($nome)){
    header("Location: /hubhorta/gerenciador/modifica_gerenciador.php?erro=nao-preenchimento&id={$id}");
    exit;
}



if(($daoUsuario->buscaPorLogin($email) != null) && $gerenciadorAntes->getEmail()!=$email){
    header("Location: /hubhorta/gerenciador/modifica_gerenciador.php?erro=gerenciador-ja-existente&id={$id}");
    exit;
}

$gerenciador = new Gerenciador($id,$nome,$email,md5($senha));
$dao = $factory->getGerenciadorDao();




$tempUsuario = $daoUsuario->buscaPorLogin($gerenciadorAntes->getEmail());

$usuario = new Usuario($tempUsuario->getId(),$email,md5($senha),$nome,'gerenciador');


$daoUsuario->altera($usuario);
$dao->altera($gerenciador);

header("Location: gerenciadores.php");
exit;

?>
