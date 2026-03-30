<?php
$tela = 'usuarios';
include "../verifica.php";

$page_title = "Usuários";

include_once "../layout_header.php";
include_once "../fachada.php";

echo "<section class='container section-forms pagina-produtos'>";

echo "<div style='display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;'>";
echo "<input autocomplete='off' name='nome' type='text' id='palavra' placeholder='Filtrar por nome...' style='padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;'>";
echo "<a href='novo_usuario.php' class='btn btn-primary' style='white-space: nowrap;'>Novo</a>";
echo "</div>";


echo '<div id="conteudo-tabela"></div>';
echo '<div id="conteudo-paginacao" class="paginacao-container-lista" ></div>';

echo "</section>";

if (isset($_GET['erro']) && $_GET['erro'] === 'impossivel-remover') {
	echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Erro ao remover',
            text: 'Esse usuario é um gerenciador hortas que ainda possui hortas cadastrados!',
            customClass: {
            popup: 'pop-up',
			    confirmButton: 'btn-vermelho'
        }
        });
    </script>";
}

if (isset($_GET['usuario-removido'])) {
	echo "<script>
		Swal.fire({
			position: 'top-end',
			icon: 'success',
			title: 'Usuario removido!',
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
				window.location.href = 'remove_usuario.php?id=' + id;
			}
		});
	}


$(document).ready(function(){
  load_data();

    function load_data(query = '', page = 1) {
        $.ajax({
            url: 'fetch_usuarios.php',
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