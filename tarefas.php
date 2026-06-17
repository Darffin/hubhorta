<?php
$tela = 'Tarefas';
include "verifica.php";

$page_title = "Tarefas";

include_once "layout_header.php";
include_once "fachada.php";

$id_horta = $_GET['id_horta'] ?? null;

echo "<section class='container section-forms pagina-tarefas'>";


echo "<div style='display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;'>";
echo "<input autocomplete='off' name='nome' type='text' id='palavra' placeholder='Filtrar por nome...' style='padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;'>";
if($_SESSION["permissao"] == 'gerenciador' || $_SESSION["permissao"] == 'admin') {
echo "<a href='nova_tarefa.php' class='btn btn-primary' style='white-space: nowrap;'>Novo</a>";
}
echo "</div>";


echo '<div id="conteudo-tabela"></div>';
echo '<div id="conteudo-paginacao" class="paginacao-container-lista" ></div>';

echo "</section>";

if (isset($_GET['tarefa-removida'])) {
	echo "<script>
		Swal.fire({
			position: 'top-end',
			icon: 'success',
			title: 'Tarefa removida!',
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
include_once "layout_footer.php";
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
				window.location.href = 'remove_tarefa.php?id=' + id;
			}
		});
	}



$(document).ready(function(){
  load_data();

    function load_data(query = '', page = 1) {
        $.ajax({
            url: '/hubhorta/tarefa/fetch_tarefas.php',
            method: 'POST',
            data: { query: query, page: page, id_horta: <?php echo json_encode($id_horta); ?> },
      success: function(data) {
    var tempDiv = $('<div>').html(data);

    var paginacao = tempDiv.find('#paginacao-separada').html();

    tempDiv.find('#paginacao-separada').remove();

    $('#conteudo-tabela').html(tempDiv.html());
    $('#conteudo-paginacao').html(paginacao);
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