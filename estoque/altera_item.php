<?php
include_once "../fachada.php";

$id = @$_GET["id"];
$id_horta = @$_GET["id_horta"];
$item = @$_GET["item"];
$quantidade = @$_GET["quantidade"];

$dao = $factory->getEstoqueDao();
$tempEstoque = $dao->buscaPorId($id);

if (empty($item) || empty($quantidade)){
    header("Location: /hubhorta/estoque/modifica_item.php?erro=nao-preenchimento&id={$id}");
    exit;
}

$estoque = new Estoque($id, $quantidade, $id_horta, $item);

$dao->altera($estoque);

header("Location: /hubhorta/estoque.php?id_horta={$id_horta}");
exit;

?>
