<?php
include_once('../fachada.php');
include_once('../verifica.php');

$nome = $_POST['query'];
$limit = 12;
$page = $_POST['page'] ?? 1;
$start = ($page - 1) * $limit;
$dao = $factory->getHortaDao();

if($_SESSION["permissao"] == 'admin'){
    $hortas = $dao->buscaComNomePaginadoAdmin($nome, $start, $limit);
    $total_data = $dao->contaComNomeAdmin($nome);
}else{
    $hortas = $dao->buscaComNomePaginadoGerenciador($nome, $start, $limit, $_SESSION["login"]);
    $total_data = $dao->contaComNomeGerenciador($nome, $_SESSION["login"]);
}

	echo "<table class='table table-hover table-responsive table-bordered'>";

	echo "<thead>";
	echo "<tr>";
	echo "<th>Id</th>";
	echo "<th>Horta</th>";
	echo "<th>Latitude</th>";
	echo "<th>Longitude</th>";
	echo "<th>Gerenciador</th>";
	echo "<th>Imagem</th>";
	echo "<th>Ações</th>";
	echo "</tr>";
	echo "</thead>";

if ($total_data > 0) {
    foreach ($hortas as $horta) {
		echo "<tr>";
		echo "<td>{$horta->getId()}</td>";
		echo "<td>{$horta->getNome()}</td>";
		echo "<td>{$horta->getLatitude()}</td>";
		echo "<td>{$horta->getLongitude()}</td>";
		echo "<td>{$horta->getGerenciador()->getNome()}</td>";
		echo "<td>{$horta->getImagem()}</td>";
		echo "<td class='text-center'>";
		echo "<a href='modifica_horta.php?id={$horta->getId()}' class='btn btn-info left-margin'>";
		echo "<span class='glyphicon glyphicon-edit'></span> Altera";
		echo "</a>";

		echo "<a href='#' class='btn btn-danger left-margin' ";
		echo "onclick=\"confirmarExclusao({$horta->getId()})\">";
		echo "<span class='glyphicon glyphicon-remove'></span> Exclui";
		echo "</a>";
		echo "</td>";
		echo "</tr>";
    }
} else echo "<tr><td colspan='7'>Nenhum produto encontrado.</td></tr>";

echo "</table>";
echo '<div id="paginacao-separada" style="display:none;">';
echo '<ul class="pagination">';

$total_links = ceil($total_data / $limit);
$page_array = [];

if ($total_links > 4) {
    if ($page < 5) {
        for ($i = 1; $i <= 5; $i++) $page_array[] = $i;
        $page_array[] = '...';
        $page_array[] = $total_links;
    } elseif ($page > $total_links - 5) {
        $page_array[] = 1;
        $page_array[] = '...';
        for ($i = $total_links - 4; $i <= $total_links; $i++) $page_array[] = $i;
    } else {
        $page_array[] = 1;
        $page_array[] = '...';
        for ($i = $page - 1; $i <= $page + 1; $i++) $page_array[] = $i;
        $page_array[] = '...';
        $page_array[] = $total_links;
    }
} else {
    for ($i = 1; $i <= $total_links; $i++) $page_array[] = $i;
}

$prev = $page - 1;
$next = $page + 1;

echo ($prev > 0) ?
    '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="' . $prev . '">Anterior</a></li>' :
    '<li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>';

foreach ($page_array as $val) {
    if ($val == '...') {
        echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
    } elseif ($val == $page) {
        echo '<li class="page-item active"><a class="page-link" href="#">' . $val . ' <span class="sr-only">(current)</span></a></li>';
    } else {
        echo '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="' . $val . '">' . $val . '</a></li>';
    }
}

echo ($next <= $total_links) ?
    '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="' . $next . '">Próximo</a></li>' :
    '<li class="page-item disabled"><a class="page-link" href="#">Próximo</a></li>';

echo '</ul>';
echo '</div>';
?>
