<?php
$page_title = "Nova Tarefa";
include_once('../fachada.php');
include_once "../layout_header.php";

$id_horta = $_GET['id_horta'] ?? null;

$dao = $factory->getHortaDao();
$voluntarios = $dao->buscaVoluntarios($id_horta);

 ?>
 <section class='container section-forms'>

    <form action='insere_tarefa.php' method='get'>
    <input type="hidden" name="id_horta" value="<?php echo $id_horta; ?>">
    <table class='table table-hover table-responsive table-bordered'>
         <tr>
            <td>Titulo</td>
            <td><input type='text' name='titulo' class='form-control' /></td>
        </tr>
         <tr>
            <td>Descrição</td>
            <td><input type='text' name='descricao' class='form-control' /></td>
        </tr>
         <tr>
            <td>Status</td>
            <td>           
            <label style="margin-right: 25px;">
                <input type="radio" name="status" value="pendente">
                Pendente
            </label>

            <label style="margin-right: 25px;">
                <input type="radio" name="status" value="em-andamento">
                Em Andamento
            </label>

            <label style="margin-right: 25px;">
                <input type="radio" name="status" value="concluida">
                Concluída
            </label>
            </td>
        </tr>

        <?php
        if($id_horta != null){
            echo"<tr>";
                echo"<td>Usuario executor</td>";
                echo"<td>";
            
                echo"<select name = \"id_usuario\">";
                    echo "<option value='' selected>Nenhum</option>";
                    foreach ($voluntarios as $umVoluntario) {
                        echo "<option value=\"" . $umVoluntario->getId() . "\"";
                        //if($umVoluntario->getId() == $id_voluntario) {
                        //    echo " selected ";
                        //} 
                        echo ">" . $umVoluntario->getNome() . "</option>\n"; 
                    }
                echo"</select>"; 
                echo"</td>";
            echo"</tr>";
        }
        ?>

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


