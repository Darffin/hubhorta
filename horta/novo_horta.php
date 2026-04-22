<?php
$page_title = "Nova Horta";
// layout do cabeçalho
include_once "../layout_header.php";
include_once "../fachada.php";
$tela = 'hortas';
include "../verifica.php";

$dao = $factory->getGerenciadorDao(); 
$gerenciadores = $dao->buscaTodos();


 ?>
 <section class='container section-forms'>
<form action="insere_horta.php" method="post" enctype="multipart/form-data">
    <table class='table table-hover table-responsive table-bordered'>
         <tr>
            <td>Nome</td>
            <td><input type='text' name='nome' class='form-control' /></td>
        </tr>

        <tr>
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

            <td>

            <!-- <form action="enviar.php" method="post" enctype="multipart/form-data"> -->
                <input type="file" name="Arquivo" id="Arquivo">
                <input type="reset" value="Apagar">
            <!-- </form> -->
            </td>

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

// layout do rodapé
include_once "../layout_footer.php";
?>
<script src="https://unpkg.com/imask"></script>

<script>

</script>



