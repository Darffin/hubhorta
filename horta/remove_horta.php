<?php
include_once "../fachada.php";

$id = @$_GET["id"];

#$horta = new Horta($id,$nome,$id_gerenciador);
$dao = $factory->getHortaDao();
$dao->removePorId($id);

header("Location: hortas.php?horta-removida");
exit;




?>