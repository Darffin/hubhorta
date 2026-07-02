<?php
$page_title = "Alterar Estoque";

include_once "../fachada.php";
$tela = 'estoque';
include "../verifica.php";

$id = @$_GET["id"];
$id_horta = @$_GET["id_horta"];

$dao = $factory->getEstoqueDao();
$estoque = $dao->buscaPorId($id);

// layout do cabeçalho
include_once "../layout_header.php";
 ?>
 <section class='container section-forms'>
<form action="altera_estoque.php" method="get">
    <table class='table table-hover table-responsive table-bordered'>
         <tr>
            <td>Item</td>
            <td><input type='text' name='item' value='<?php echo $estoque->getNomeItem();?>' class='form-control' /></td>
        </tr>
        <tr>
            <td>Quantidade</td>
            <td><input type='number' name='quantidade' value='<?php echo $estoque->getQuantidade();?>'class='form-control' /></td>
        </tr>
        <tr>
            <td>
            </td>
            <td>
                <button type="submit" class="btn btn-primary">Alterar</button>
                <a href='/hubhorta/estoque.php?id_horta=<?php echo $id_horta; ?>' class='btn btn-primary left-margin'>Cancela</a>
            </td>
        </tr>
    </table>
    <input type='hidden' name='id' value='<?php echo $estoque->getId();?>'/>
    <input type='hidden' name='id_horta' value='<?php echo $id_horta;?>'/>
</form>
</section>

<?php
if (isset($_GET['erro']) && $_GET['erro'] === 'nao-preenchimento') {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Erro de alteração de estoque',
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


