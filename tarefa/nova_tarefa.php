<?php
$page_title = "Novo Usuário";

include_once "../layout_header.php";
 ?>
 <section class='container section-forms'>
<form action="insere_usuario.php" method="get">
    <table class='table table-hover table-responsive table-bordered'>
         <tr>
            <td>Titulo</td>
            <td><input type='text' name='login' class='form-control' /></td>
        </tr>
         <tr>
            <td>Descrição</td>
            <td><input type='text' name='descricao' class='form-control' /></td>
        </tr>
         <tr>
            <td>Status</td>
            <td>           
            <select name = "status">
            <option value="pendente">Pendente</option>
            <option value="em-andamento">Em Andamento</option>
            <option value="concluida">Concluída</option>
            </select>
            </td>
        </tr>
        <tr>
            <td>Usuario executor</td>
            <td>           
            <select name = "usuario">
            <option value="usuario">teste 1</option>
            <option value="gerenciador">teste 2</option>
            </select>
            </td>
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


