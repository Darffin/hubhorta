
<?php
include_once('fachada.php');

// -- Pagina das Hortas -- //

/*
$nome = $_POST['query'];
$limit = $_POST['limit'];
$page = $_POST['page'] ?? 1;
$start = ($page - 1) * $limit;

$dao = $factory->getHortaDAO();
$Horta = $dao->buscaComNomePaginado($nome, $start, $limit);
$total_data = $dao->contaComNome($nome);

if ($total_data > 0) {
    foreach ($Horta as $Horta) {
        echo ' <div class="Horta-card" >
                    <a href="/web-petshop/mostra_Horta.php?id='.$Horta->getId().'&title='.$Horta->getNome().'" class="">
                        <div class="image-container">
                            <img src="images/uploads/' . $Horta->getImagem() . '"/>';
        echo            '</div>
                        <h2>' . $Horta->getNome() . '</h2>
                        <div class="preco">R$ ' . $Horta->getValor() . '</div>
                </a>';
?>
                <button>
                <img src=""> <!--  -->
                </button>
                </div>
<?php
    }
} else echo '<div class="Horta-card"><h2>Nenhuma Horta encontrada!</h2></div>';

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
*/
?>


