<?php
include_once "../fachada.php";
include_once "../verifica.php";

$id_usuario = @$_SESSION["id_usuario"];
$id_horta = @$_POST["id_horta"];


$dao = $factory->getUsuarioDao();
$usuario = $dao->buscaPorId($id_usuario);
$horta = $factory->getHortaDao()->buscaPorId($id_horta);
$dao->voluntariar($usuario, $horta);
$usuarioCadastrado = $dao->buscaPorLogin($login);

header("Location: /hubhorta/mostra_horta.php?id=$id_horta");
exit;

?>