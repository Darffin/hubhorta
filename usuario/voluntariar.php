<?php
include_once "../fachada.php";
include_once "../verifica.php";

$id_usuario = $_SESSION["id_usuario"];
$id_horta = $_POST["id_horta"];

$dao = $factory->getUsuarioDao();

if (!$dao->buscaHortaVoluntariada($id_usuario, $id_horta)) {

    $usuario = $dao->buscaPorId($id_usuario);
    $horta = $factory->getHortaDao()->buscaPorId($id_horta);

    $dao->voluntariar($usuario, $horta);

    echo "sucesso";
} else {
    echo "ja-voluntariada";
}

?>