<?php
include_once "../fachada.php";
include_once "../verifica.php";

$id_usuario = $_SESSION["id_usuario"];
$id_horta = $_POST["id_horta"];

$dao = $factory->getUsuarioDao();


$dao->desvoluntariar($id_usuario, $id_horta);


echo "sucesso";


?>