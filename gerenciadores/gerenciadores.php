<?php
// layout do cabeçalho

$tela = 'Gerenciadores';
include "../verifica.php";

$page_title = "Gerenciadores";

include_once "../layout_header.php";
include_once "../fachada.php";

echo "<section class='container section-forms pagina-hortas'>";


echo "<div style='display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;'>";
echo "<input autocomplete='off' name='nome' type='text' id='palavra' placeholder='Filtrar por nome...' style='padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;'>";
echo "<a href='novo_gerenciador.php' class='btn btn-primary' style='white-space: nowrap;'>Novo</a>";
echo "</div>";


echo '<div id="conteudo-tabela"></div>';
echo '<div id="conteudo-paginacao" class="paginacao-container-lista" ></div>';
echo "</section>";

//inputPalavra.addEventListener


if (isset($_GET['erro']) && $_GET['erro'] === 'impossivel-remover') {
	echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Erro ao remover',
            text: 'Esse gerenciador ainda possui hortas cadastradas!',
            customClass: {
            popup: 'pop-up',
			confirmButton: 'btn-vermelho'
        }
        });
    </script>";
}

if (isset($_GET['gerenciador-removido'])) {
	echo "<script>
		Swal.fire({
			position: 'top-end',
			icon: 'success',
			title: 'Gerenciador removido!',
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

// layout do rodapé
include_once "../layout_footer.php";
?>

<script>
	function confirmarExclusao(id) {
		Swal.fire({
			title: "Tem certeza?",
			text: "Essa ação não poderá ser desfeita!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#d33",
			cancelButtonColor: "#aaa",
			confirmButtonText: "Sim, excluir!",
			cancelButtonText: "Cancelar",
			customClass: {
				popup: 'pop-up',
				confirmButton: 'btn-vermelho'
			}
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = 'remove_gerenciador.php?id=' + id;
			}
		});

	}

$(document).ready(function(){
  load_data();

    function load_data(query = '', page = 1) {
        $.ajax({
            url: 'fetch_gerenciadores.php',
            method: 'POST',
            data: { query: query, page: page },
      success: function(data) {
        var tempDiv = $('<div>').html(data);
        $('#conteudo-tabela').html(tempDiv.find('table'));
        $('#conteudo-paginacao').html(tempDiv.find('#paginacao-separada').html());
      }
    });
  }

  $(document).on('click', '.page-link', function(){
    var page = $(this).data('page_number');
    var query = $('#palavra').val();
    load_data(query, page);
  });

  $('#palavra').keyup(function(){
    var query = $(this).val();
    load_data(query, 1);
  });
});

</script>