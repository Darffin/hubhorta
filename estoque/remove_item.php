<?php
include_once "../fachada.php";

$id = @$_GET["id"];
$id_horta = @$_GET["id_horta"];

$dao = $factory->getEstoqueDao();


$dao->removePorId($id);

header("Location: /hubhorta/estoque.php?id_horta=" . $id_horta . "&item-removido");
exit;

?>