<?php
$page_title = "Alterar Tarefa";

include_once "../fachada.php";
$tela = 'tarefas';
include "../verifica.php";

$id = @$_GET["id"];

$dao = $factory->getTarefaDao();
$tarefa = $dao->buscaPorId($id);

// layout do cabeçalho
include_once "../layout_header.php";
 ?>
 <section class='container section-forms'>
<form action="altera_tarefa.php" method="get">
    <table class='table table-hover table-responsive table-bordered'>
         <tr>
            <td>Titulo</td>
            <td><input type='text' name='titulo' value='<?php echo $tarefa->getTitulo();?>' class='form-control' /></td>
        </tr>
        <tr>
            <td>Descrição</td>
            <td><input type='text' name='descricao' value='<?php echo $tarefa->getDescricao();?>'class='form-control' /></td>
        </tr>
        <tr>
            <td>Status</td>
            <td><input type='text' name='status' value='<?php echo $tarefa->getStatus();?>'class='form-control' /></td>
        </tr>
        <tr>
            <td>
            </td>
            <td>
                <button type="submit" class="btn btn-primary">Alterar</button>
                <a href='/hubhorta/tarefas.php' class='btn btn-primary left-margin'>Cancela</a>
            </td>
        </tr>
    </table>
    <input type='hidden' name='id' value='<?php echo $tarefa->getId();?>'/>
</form>
</section>

<?php
if (isset($_GET['erro']) && $_GET['erro'] === 'nao-preenchimento') {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Erro de criação de tarefa',
            text: 'Você precisa preencher todos os campos!',
            customClass: {
            popup: 'pop-up',
			confirmButton: 'btn-vermelho'
        }
        });
    </script>";
}


// layout do rodapé
include_once "../layout_footer.php";
?>


