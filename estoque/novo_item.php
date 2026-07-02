<?php
$page_title = "Nova Tarefa";
include_once('../fachada.php');
include_once "../layout_header.php";

$id_horta = $_GET['id_horta'] ?? null;

$dao = $factory->getHortaDao();
$voluntarios = $dao->buscaVoluntarios($id_horta);

 ?>
 <section class='container section-forms'>

    <form action='insere_item.php' method='get'>
    <input type="hidden" name="id_horta" value="<?php echo $id_horta; ?>">
    <table class='table table-hover table-responsive table-bordered'>
         <tr>
            <td>O que você deseja adicionar ao estoque?</td>
            <td><input type='text' name='item' class='form-control' /></td>
        </tr>
         <tr>
            <td>Quantidade de estoque</td>
            <td><input type='number' name='quantidade' class='form-control' /></td>
        </tr>

            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Inserir</button>
            </td>
        </tr>
    </table>
</form>
</section>

<?php

if (isset($_GET['erro']) && $_GET['erro'] === 'nao-preenchimento') {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Erro de criação de tarefa',
            text: 'Você precisa preencher todos os campos para se cadastrar!',
            customClass: {
            popup: 'pop-up',
			confirmButton: 'btn-vermelho'
        }
        });
    </script>";
}
?>



<?php
include_once "../layout_footer.php";
?>


