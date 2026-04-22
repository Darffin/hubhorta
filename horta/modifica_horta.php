<?php
$page_title = "Alterar um produto";

include_once "../fachada.php";
$tela = 'hortas';
include "../verifica.php";

$id = @$_GET["id"];

$dao = $factory->getHortaDao();
$horta = $dao->buscaPorId($id);

$dao = $factory->getGerenciadorDao();
$gerenciadores = $dao->buscaTodos();

include_once "../layout_header.php";
 ?>
 <section class='container section-forms'>
<form action="altera_horta.php" method="post" enctype="multipart/form-data">
    <table class='table table-hover table-responsive table-bordered'>
         <tr>
            <td>Nome</td>
            <td><input type='text' name='nome' value='<?php echo $horta->getNome();?>' class='form-control' /></td>
        </tr>

        <tr>
            <td>Gerenciador</td>
            <td>
            <label for="id_gerenciador">Gerenciador:</label>            
            <select name = "id_gerenciador">
            <?php
                foreach ($gerenciadores as $umGerenciador) {
                    echo "<option value=\"" . $umGerenciador->getId() . "\"";
                    //if($umGerenciador->getId() == $id_gerenciador) {
                    //    echo " selected ";
                    //} 
                    echo ">" . $umGerenciador->getNome() . "</option>\n"; 
                }
            ?>
            </select>
            </td>
        </tr>

        <tr>
            <td>Imagem</td>
            <td>
                <p>Imagem atual: <?php echo $horta->getImagem();?><p>
                <input type="file" name="Arquivo" id="Arquivo">
                <input type="reset" value="Apagar">
            </td>
        </tr>

        <tr>
            <td>
            </td>
            <td>
                <button type="submit" class="btn btn-primary">Alterar</button>
                <a href='produtos.php' class='btn btn-primary left-margin'>Cancela</a>
            </td>
        </tr>
    </table>
    <input type='hidden' name='id' value='<?php echo $horta->getId();?>'/>
</form>
</section>

<?php
if (isset($_GET['erro']) && $_GET['erro'] === 'nao-preenchimento') {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Erro ao adicionar horta',
            text: 'Você precisa preencher todos os campos para adicionar uma horta!',
            customClass: {
            popup: 'pop-up',
			confirmButton: 'btn-vermelho'
        }
        });
    </script>";
}

if (isset($_GET['erro']) && $_GET['erro'] === 'nao-selecionou-arquivo') {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Erro ao adicionar horta',
            text: 'Você precisa adicionar uma foto à sua horta!',
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

<script src="https://unpkg.com/imask"></script>

<script>

</script>


