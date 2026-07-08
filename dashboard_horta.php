<?php
$page_title = "Pagina Inicial";
// layout do cabeçalho
include_once "layout_header.php";
include_once "fachada.php";

$id_horta = $_GET['id'] ?? null;


$dao = $factory->getHortaDao();
$daoGerenciador = $factory->getGerenciadorDao();
$voluntarios = count($dao->buscaVoluntarios($id_horta));
$status = $daoGerenciador->contaPorStatusHorta($id_horta);

$daoEstoque = $factory->getEstoqueDao();
$estoques = $daoEstoque->buscaTodosPorHorta($id_horta);

$nomesItens = [];
$quantidades = [];

foreach ($estoques as $estoque) {
    $nomesItens[] = $estoque->getNomeItem();
    $quantidades[] = (int)$estoque->getQuantidade();
}

 ?>
	<section>
	<div class="container">
    <div class="row">
        <div class="col-md-5 dados-dashboard">
            <article>
                <h1>Voluntários</h1>
                <h1><?php echo $voluntarios; ?></h1>
            </article>
        </div>

        <div class="col-md-5 dados-dashboard">
            <a href="tarefas.php?id_horta=<?php echo $id_horta; ?>">
                <article>
                    <h1>Tarefas Pendentes</h1>
                    <h1><?php echo $status['pendentes']; ?></h1>
                </article>
            </a>
        </div>

        <div class="col-md-2">
            <a href="estoque.php?id_horta=<?php echo $id_horta; ?>">
                <article>
                <h2 style="height: 80px;">Estoque</h2>
            </article>
            </a>
        </div>

    </div>

<div class="row">
    <div class="col-md-6 grafico">
        <article>
            <div id="graficoPizza" style="height:300px;"></div>
        </article>
    </div>
    <div class="col-md-6 grafico">
        <article>
            <div id="graficoEstoque" style="height:300px;"></div>
        </article>
    </div>
</div>
</div>
	</section>
<?php

// layout do rodapé
include_once "layout_footer.php";
?>

<script>

    const pendentes = <?= $status['pendentes'] ?>;
    const andamento = <?= $status['em_andamento'] ?>;
    const concluidas = <?= $status['concluidas'] ?>;

    var graficoPizza = echarts.init(document.getElementById('graficoPizza'));
    var optionPizza = {
        title: {
            text: 'Tarefas da horta',
            left: 'center'
        },
        tooltip: {
            trigger: 'item'
        },
        legend: {
            orient: 'vertical',
            left: 'left'
        },
        series: [
{
    name: 'Tarefas',
    type: 'pie',
    radius: '65%',

    data: [

        {
            value: pendentes,
            name: 'Pendentes'
        },

        {
            value: andamento,
            name: 'Em andamento'
        },

        {
            value: concluidas,
            name: 'Concluídas'
        }

    ],

    label:{
        formatter: '{b}\n{d}%'
    },

    emphasis:{

        itemStyle:{
            shadowBlur:10,
            shadowOffsetX:0,
            shadowColor:'rgba(0,0,0,0.5)'
        }

    }
}
]
    };
    graficoPizza.setOption(optionPizza);

    
const nomesItens = <?= json_encode($nomesItens); ?>;
const quantidades = <?= json_encode($quantidades); ?>;

var graficoEstoque = echarts.init(document.getElementById('graficoEstoque'));

var optionEstoque = {

    title: {
        text: 'Quantidade de Itens em Estoque',
        left: 'center'
    },

    tooltip: {
        trigger: 'axis'
    },

    xAxis: {
        type: 'category',
        data: nomesItens,
        axisLabel: {
            interval: 0,
            rotate: 30
        }
    },

    yAxis: {
        type: 'value',
        name: 'Quantidade'
    },

    series: [
        {
            name: 'Quantidade',
            type: 'bar',
            data: quantidades,

            label: {
                show: true,
                position: 'top'
            },

            itemStyle: {
                borderRadius: [5, 5, 0, 0]
            }
        }
    ]

};

graficoEstoque.setOption(optionEstoque);

</script>
