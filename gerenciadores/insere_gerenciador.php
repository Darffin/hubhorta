<?php
include_once "../fachada.php";

$nome = @$_GET["nome"];
$email = @$_GET["email"];
$senha = @$_GET["senha"];

$dao = $factory->getGerenciadorDao();
$gerenciadores = $dao->buscaTodos();

$daoUsuario = $factory->getUsuarioDao();


if($daoUsuario->buscaPorLogin($email) != null){
    header("Location: /hubhorta/gerenciadores/novo_gerenciador.php?erro=gerenciador-ja-existente");
}

if (empty($nome) || empty($email) || empty($senha)){
    header("Location: /hubhorta/gerenciadores/novo_gerenciador.php?erro=nao-preenchimento");
    exit;
}

$usuario = new Usuario(null,$email,md5($senha),$nome,'gerenciador');
$daoUsuario->insere($usuario);
$usuarioCadastrado = $daoUsuario->buscaPorLogin($email);

$gerenciador = new Gerenciador($usuarioCadastrado->getId(),$nome,$email,md5($senha));
$dao = $factory->getGerenciadorDao();
$dao->insere($gerenciador);

header("Location: /hubhorta/gerenciadores/gerenciadores.php");
exit;

?>