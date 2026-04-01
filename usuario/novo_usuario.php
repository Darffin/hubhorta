<?php
$page_title = "Novo Usuário";

include_once "../layout_header.php";
 ?>
 <section class='container section-forms'>
<form action="insere_usuario.php" method="get">
    <table class='table table-hover table-responsive table-bordered'>
         <tr>
            <td>Login</td>
            <td><input type='text' name='login' class='form-control' /></td>
        </tr>
         <tr>
            <td>Senha</td>
            <td><input type='password' id='senha' name='senha' class='form-control' /></td>
        </tr>
         <tr>
            <td>Nome</td>
            <td><input type='text' name='nome' class='form-control' /></td>
        </tr>
        <tr>
            <td>Nos conte o que você quer fazer!</td>
            <td>           
            <select name = "permissao">
            <option value="usuario">Voluntario</option>
            <option value="gerenciador">Administrar</option>
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
if (isset($_GET['erro']) && $_GET['erro'] === 'conta-ja-existente') {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Erro de criação de conta',
            text: 'Já existe uma conta cadastrada com esse nome de usuario! :(',
            customClass: {
            popup: 'pop-up',
			confirmButton: 'btn-vermelho'
        }
        });
    </script>";
}

if (isset($_GET['erro']) && $_GET['erro'] === 'nao-preenchimento') {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Erro de criação de conta',
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


