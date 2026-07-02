<?php
include_once('../fachada.php');
INCLUDE_ONCE('../verifica.php');

$nome = $_POST['query'];
$limit = 15;
$page = $_POST['page'] ?? 1;
$id_horta = $_POST['id_horta'] ?? null;
$start = ($page - 1) * $limit;

$dao = $factory->getEstoqueDao();

$estoques = $dao->buscaPorHortaPaginado($id_horta, $start, $limit);
$total_data = $dao->contaPorHorta($id_horta);


if ($total_data > 0) {
    echo '<div class="tarefas-grid">';
    foreach ($estoques as $item) {
        echo'<a href="/hubhorta/estoque/modifica_item.php?id=' . $item->getId() . '">';
        echo '
                    <div class="tarefa-card" data-id="'.$item->getId().'">';
                        if($_SESSION["permissao"] == 'gerenciador' || $_SESSION["permissao"] == 'admin'){
                            //echo '<a href="/hubhorta/estoque/remove_item.php?id='.$item->getId().'&id_horta=' . $id_horta . '" class="col botao-deletar">X</a>';
                        }
        echo            '<h4>Item: ' . $item->getNomeItem() .'</h4>
                        <h4>Quantidade: ' . $item->getQuantidade() . '</h4>';
                        
        echo        '</div>';
        echo'<a/>';
    }
    echo '</div>';
} else echo '<div class="tarefa-card"><h2>Nenhuma tarefa encontrada!</h2></div>';

echo '<div id="paginacao-separada" style="">';
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


