<?php
//include "verifica.php";
include_once "fachada.php";
if (isset($_GET['title'])) {
    $page_title = $_GET['title'];
}
include_once "layout_header.php";

$id = $_GET['id'];
$dao = $factory->getHortaDAO();
$horta = $dao->buscaPorId($id);
if (!isset($_GET['title'])) {
    $page_title = $horta->getNome();
}


$limit = 5;
$page = 1;
$start = ($page - 1) * $limit;

$dao = $factory->getHortaDAO();
$hortas = $dao->buscaComNomePaginado('', $start, $limit);
$total_data = $dao->contaComNome('');

echo "
	<section class='container section-forms pagina-produtos'>
	<div class=''>
    <div class='row'>
        <div class='col-md-6 mostra-produto'>
            <div class='mostra-imagem'>
                <img src='/web-petshop/images/uploads/" . $horta->getImagem() . "'/>
                <!-- <a href=''><button>Carrinho?</button></a> -->
            </div>
        </div>
        <div class='col-md-6 mostra-info d-flex flex-column'>
            <div class='info-titulo row'>" . $horta->getNome() . "</div>
            
";
?>
        <!-- <div class='info-localizacao row'>" . $horta->getLocalizacao() . "</div> -->
        <!-- <div class='info-descricao row'>" . $horta->getDescricao() . "</div> -->

<div class='mostra-acoes mt-auto mt-auto d-flex flex-column align-items-center w-100'>

    <?php
        echo "<button onclick='' class='btn btn-info row'>Se voluntariar</button> 
        <button onclick='adicionarInteresse(".$horta->getId().", select.value);' class='btn btn-info row'>Adicionar aos interesses</button>";
    ?>
</div>
</div>

</div>
<hr style="border: 1px solid black;">
<div class='row'>
    <section class="lista">
        <div class='produto-grid' id='dynamic_content'></div>
        <div class='paginacao-container' id='paginacao'></div>


         <ul class="item-lista" style="padding-left: 0px;"> 
        <?php 
        if ($total_data > 0) {
            foreach ($hortas as $horta) {
                echo '
                        <li class="horta-card">
                            <a href="/web-petshop/mostra_horta.php?id=' . $horta->getId() . '&title=' . $horta->getNome() . '" class="">
                                <div class="image-container" style="height: 230px;">
                                    <img src="images/uploads/' . $horta->getImagem() . '"/>
                                </div>
                            </a>
                        </li>
                    ';
            }
        }
        ?>
    
    
    <!-- COMEÇO DA PUTARIA-->

    <!-- FIM DA PUTARIA-->
    </section>
</div>
</section>

<?php

if (isset($_GET['pedido-criado'])) {
    echo "<script>
		Swal.fire({
			position: 'top-end',
			icon: 'success',
			title: 'Pedido criado!',
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
    function enviarPara(destino) {
        const quantidade = document.getElementById('quantidade_produto').value;
        window.location.href = destino + "&quantidade_produto=" + quantidade;
    }

    $(document).ready(function(){

  load_data(1,'', 4);

  function load_data(page, query = '', limite) {
    $.ajax({
      url: "fetch_dao.php",
      method: "POST",
      data: { page: page, query: query, limit:limite },
      success: function(data) {
        var tempDiv = $('<div>').html(data);
        $('#dynamic_content').html(tempDiv.find('.produto-card'));
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
</script>