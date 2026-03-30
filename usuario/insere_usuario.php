<?php
include_once "../fachada.php";

$login = @$_GET["login"];
$senha = @$_GET["senha"];
$nome = @$_GET["nome"];
$permissao = @$_GET["permissao"];


$dao = $factory->getUsuarioDao();
$usuarios = $dao->buscaTodos();


if($dao->buscaPorLogin($login) != null){
    header("Location: /web-petshop/usuario/novo_usuario.php?erro=conta-ja-existente");
}

if (empty($login) || empty($senha) || empty($nome)){
    header("Location: /web-petshop/usuario/novo_usuario.php?erro=nao-preenchimento");
    exit;
}

/*
if($permissao=='dono'){
    $dono = new dono(null,$nome,$login,$senha);
    $daodono = $factory->getdonoDao();
    $daodono->insere($dono);
}
*/

$usuario = new Usuario(null,$login,$senha,$nome,$permissao);
$dao->insere($usuario);

header("Location: usuarios.php");
exit;

?>