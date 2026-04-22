<?php
include_once "../fachada.php";

$id = @$_POST["id"];
$nome = $_POST['nome'];
$lat = $_POST['latitude'];
$lon = $_POST['longitude'];
$id_gerenciador = @$_POST["id_gerenciador"];

$dao = $factory->getHortaDao();

if (empty($nome) || empty($lat) || empty($lon) || empty($id_gerenciador)){
    header("Location: /hubhorta/horta/modifica_horta.php?erro=nao-preenchimento");
    exit;
}

$horta->setGerenciador(Gerenciador::withId($id_gerenciador));
$dao->altera($horta);

header("Location: hortas.php");
exit;

?>
