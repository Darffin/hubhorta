<?php
include_once "../fachada.php";

$id_horta = @$_GET["id_horta"];
$item = @$_GET["item"];
$quantidade = @$_GET["quantidade"];


$dao = $factory->getEstoqueDao();


if (empty($item) || empty($quantidade)){
    header("Location: /hubhorta/estoque/novo_item.php?id_horta=$id_horta&erro=nao-preenchimento");
    exit;
}

/*
if($permissao=='dono'){
    $dono = new dono(null,$nome,$login,$senha);
    $daodono = $factory->getdonoDao();
    $daodono->insere($dono);
}
*/


$estoque = new Estoque(null, $quantidade, $id_horta, $item);
$dao->insere($estoque);


header("Location: /hubhorta/estoque.php?id_horta=" . $id_horta . "&item-inserido");
exit;

?>