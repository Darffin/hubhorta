<?php
//include "verifica.php";
include_once "fachada.php";
if (isset($_GET['title'])) {
    $page_title = $_GET['title'];
}
$id = $_GET['id_horta'];
$dao = $factory->getHortaDAO();
$horta = $dao->buscaPorId($id);

if (!isset($_GET['title'])) {
    $page_title = $horta->getNome();
}
include_once "layout_header.php";

$limit = 5;
$page = 1;
$start = ($page - 1) * $limit;

$dao = $factory->getHortaDAO();
$hortas = $dao->buscaComNomePaginado('', $start, $limit);
$total_data = $dao->contaComNome('');

$lat = $horta->getLatitude();
$lng = $horta->getLongitude();

$url = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=$lat&lon=$lng";

$options = [
    "http" => [
        "header" => "User-Agent: HubHorta/1.0\r\n"
    ]
];

$context = stream_context_create($options);

$resposta = file_get_contents($url, false, $context);

$dados = json_decode($resposta, true);
$endereco = $dados['address'];

echo "
	<section class='container section-forms pagina-hortas'>
	<div class=''>
    <div class='row'>
        <div class='col-md-6 mostra-horta'>
            <div class='mostra-imagem'>
                <img src='/hubhorta/images/uploads/" . $horta->getImagem() . "'/>
            </div>
        </div>
        <div class='col-md-6 mostra-info d-flex flex-column'>
            <div class='info-titulo'>" . $horta->getNome() . "</div>

            <div class='info-localizacao'>
                📍 " . (isset($endereco['road']) ? $endereco['road'] . ", " : "") . (isset($endereco['city']) ? $endereco['city'] : "") . "
            </div>

            <div class='info-descricao'>
                " . nl2br($horta->getDescricao()) . "
            </div>

            
";
?>
        <!-- <div class='info-localizacao row'>" . $horta->getLocalizacao() . "</div> -->
        <!-- <div class='info-descricao row'>" . $horta->getDescricao() . "</div> -->

<div class='mostra-acoes mt-auto mt-auto d-flex flex-column align-items-center w-100'>

    <?php
        if(isset($_SESSION["id_usuario"]))
        if($_SESSION["permissao"] == 'usuario') {
            echo "<button onclick='seVoluntariar(".$horta->getId().");' class='btn btn-info row'>Se voluntariar</button>";
        }
        ?>
</div>
</div>

</div>
<hr style="border: 1px solid black;">
<div class='row'>
    <section class="lista">
        <div class='horta-grid' id='dynamic_content'></div>
        <div class='paginacao-container' id='paginacao'></div>

         <ul class="item-lista" style="padding-left: 0px;"> 
        <?php 
        if ($total_data > 0) {
            shuffle($hortas);
            foreach ($hortas as $horta) {
                echo '
                        <li class="horta-card">
                            <a href="/hubhorta/mostra_horta.php?id_horta=' . $horta->getId() . '&title=' . $horta->getNome() . '" class="">
                                <div class="image-container" style="height: 230px;">
                                    <img src="images/uploads/' . $horta->getImagem() . '"/>
                                </div>
                            </a>
                        </li>
                    ';
            }
        }
        ?>
    
    </section>
</div>
</section>

<?php

if (isset($_GET['horta-alterada'])) {
    echo "<script>
		Swal.fire({
			position: 'top-end',
			icon: 'success',
			title: 'Horta alterada!',

			showConfirmButton: false,
			timer: 1500,
       backdrop: `
     rgba(255, 255, 255, 0)
  `,
			customClass: {
            popup: 'pop-up'
        }
			});
    </script>";
}

include_once "layout_footer.php";
?>

<script>

    $(document).ready(function(){

  load_data(1,'', 4);

  function load_data(page, query = '', limite) {
    $.ajax({
      url: "fetch_dao.php",
      method: "POST",
      data: { page: page, query: query, limit:limite },
      success: function(data) {
        var tempDiv = $('<div>').html(data);
        $('#dynamic_content').html(tempDiv.find('.horta-card'));
        $('#paginacao').html(tempDiv.find('#paginacao-separada').html());
      }
    });
  }

  $(document).on('click', '.page-link', function(){
    var page = $(this).data('page_number');
    var query = '';
    var limite = 4;
    load_data(page, query, limite);
  });
});



function seVoluntariar(id_horta) {
    $.ajax({
        url: "usuario/voluntariar.php",
        method: "POST",
        data: { id_horta: id_horta},
        success: function(response) {
            if(response.trim() === "sucesso") {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Você se voluntariou para essa horta!',
                    showConfirmButton: false,
                    timer: 1500,
                    backdrop: `rgba(255, 255, 255, 0)`,
                    customClass: { popup: 'pop-up' }
                }).then(() => {
                    location.reload();
                });
            } else if(response.trim() === "ja-voluntariada") {
                Swal.fire({
                    position: 'top-end',
                    icon: 'info',
                    title: 'Você já é voluntário dessa horta!',
                    showConfirmButton: false,
                    timer: 1500,
                    backdrop: `rgba(255, 255, 255, 0)`,
                    customClass: { popup: 'pop-up' }
                });
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Erro ao se voluntariar!',
                    showConfirmButton: false,
                    timer: 1500,
                    backdrop: `rgba(255, 255, 255, 0)`,
                    customClass: { popup: 'pop-up' }
                });
            }
        }
    });
}

</script>