<?php
include_once "../fachada.php";
include_once "../verifica.php";

$id_horta = $_POST["id_horta"];

$dao = $factory->getHortaDao();

if($dao->removePorId($id_horta)) {
    echo "sucesso";
} else {
    echo "erro";
}

?>