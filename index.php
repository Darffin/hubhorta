<?php
$page_title = "Pagina Inicial";
// layout do cabeçalho
include_once "layout_header.php";


 ?>
	<section>
	<div class="container">
    <div class="row">
        <div class="col-md-5 dados-dashboard">
            <article>
                <h1>Voluntários</h1>
                <h1>3</h1>
            </article>
        </div>
        <div class="col-md-5 dados-dashboard">
            <article>
                <h1>Hortas Cadastradas</h1>
                <h1>1</h1>
            </article>
        </div>

        <div class="col-md-2">
            <a href="Hortas_disponiveis.php">
                <article>
                <h2 style="height: 80px;">Perfil do Gerenciador</h2>
                <div class="img-box inicial-img">
                    <img class="img-fluid mb-2" src="images/image1.jpg">
                </div>
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
            <div id="graficoLinha" style="height:300px;"></div>
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
                name: 'Voluntários',
                type: 'pie',
                radius: '50%',
                data: [
                    { value: 10, name: 'Voluntário A' },
                    { value: 20, name: 'Voluntário B' },
                    { value: 30, name: 'Voluntário C' }
                ],
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };
    graficoPizza.setOption(optionPizza);

    var graficoLinha = echarts.init(document.getElementById('graficoLinha'));
    var optionLinha = {
        title: {
            text: 'Tarefas Concluídas por Mês',
            left: 'center'
        },
        tooltip: {
            trigger: 'axis'
        },
        xAxis: {
            type: 'category',
            data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                name: 'Tarefas Concluídas',
                type: 'line',
                data: [5, 15, 25, 30, 20, 45]
            }
        ]
    };
    graficoLinha.setOption(optionLinha);

</script>
