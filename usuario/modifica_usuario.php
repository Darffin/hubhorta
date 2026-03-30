<?php
$page_title = "Alterar Usuário";

include_once "../fachada.php";
$tela = 'usuarios';
include "../verifica.php";

$id = @$_GET["id"];

$dao = $factory->getUsuarioDao();
$usuario = $dao->buscaPorId($id);

// layout do cabeçalho
include_once "../layout_header.php";
 ?>
 <section class='container section-forms'>
<form action="altera_usuario.php" method="get">
    <table class='table table-hover table-responsive table-bordered'>
         <tr>
            <td>Login</td>
            <td><input type='text' name='login' value='<?php echo $usuario->getLogin();?>' class='form-control' /></td>
        </tr>
        <tr>
            <td>Nome</td>
            <td><input type='text' name='nome' value='<?php echo $usuario->getNome();?>'class='form-control' /></td>
        </tr>
        <tr>
            <td>Senha</td>
            <td><input type='password' name='senha' id= 'senha' class='form-control' /></td>
        </tr>
        <tr>
            <td>
            </td>
            <td>
                <button type="submit" class="btn btn-primary">Alterar</button>
                <a href='usuarios.php' class='btn btn-primary left-margin'>Cancela</a>
            </td>
        </tr>
    </table>
    <input type='hidden' name='id' value='<?php echo $usuario->getId();?>'/>
</form>
</section>

<?php
if (isset($_GET['erro']) && $_GET['erro'] === 'nao-preenchimento') {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Erro de criação de conta',
            text: 'Você precisa preencher todos os campos!',
            customClass: {
            popup: 'pop-up',
			confirmButton: 'btn-vermelho'
        }
        });
    </script>";
}

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

// layout do rodapé
include_once "../layout_footer.php";
?>


