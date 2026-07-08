<?php
$page_title = "Pagina Inicial";
// layout do cabeçalho
include_once "layout_header.php";
include_once "fachada.php";
//include_once "verifica.php";

$daoHorta = $factory->getHortaDao();

$voluntarios = $daoHorta->contaVoluntariosGerenciador($_SESSION['id_usuario']);
$quantidade_hortas = $daoHorta->contaHortasGerenciador($_SESSION['id_usuario']);

$daoGerenciador = $factory->getGerenciadorDao();

$status = $daoGerenciador->contaPorStatusGerenciador($_SESSION['id_usuario']);

$voluntariosPorHorta = $daoHorta->contaVoluntariosPorHorta($_SESSION['id_usuario']);
$nomes = [];
$totais = [];

foreach ($voluntariosPorHorta as $horta){
    $nomes[] = $horta['nome'];
    $totais[] = (int)$horta['total'];
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
            <article>
                <h1>Hortas Cadastradas</h1>
                <h1><?php echo $quantidade_hortas; ?></h1>
            </article>
        </div>

        <div class="col-md-2">
            <a href="Hortas_disponiveis.php">
                <article>
                <h2 style="height: 80px;">Perfil</h2>
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
            <div id="graficoBarra" style="height:300px;"></div>
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
    // Configuração do gráfico de pizza
    

    const pendentes = <?= $status['pendentes'] ?>;
    const andamento = <?= $status['em_andamento'] ?>;
    const concluidas = <?= $status['concluidas'] ?>;

    var graficoPizza = echarts.init(document.getElementById('graficoPizza'));
    var optionPizza = {
        title: {
            text: 'Distribuição de Tarefas',
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


    const nomesHortas = <?= json_encode($nomes); ?>;
    const totalVoluntarios = <?= json_encode($totais); ?>;

    var graficoBarra = echarts.init(document.getElementById('graficoBarra'));

var optionBarra = {

    title: {
        text: 'Voluntários por Horta',
        left: 'center'
    },

    tooltip: {
        trigger: 'axis'
    },

    xAxis: {
        type: 'category',
        data: nomesHortas,
        axisLabel: {
            interval: 0,
            rotate: 20
        }
    },

    yAxis: {
        type: 'value',
        name: 'Voluntários'
    },

    series: [
        {
            name: 'Voluntários',
            type: 'bar',
            data: totalVoluntarios,

            label:{
                show:true,
                position:'top'
            },

            itemStyle:{
                borderRadius:[6,6,0,0]
            }
        }
    ]

};

graficoBarra.setOption(optionBarra);

</script>
