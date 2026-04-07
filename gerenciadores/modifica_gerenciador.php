<?php
$page_title = "Alterar um gerenciador";

include_once "../fachada.php";
$tela = 'gerenciadores';
include "../verifica.php";

$id = @$_GET["id"];

$dao = $factory->getGerenciadorDao();
$gerenciador = $dao->buscaPorId($id);

// layout do cabeçalho
include_once "../layout_header.php";
 ?>
 <section class='container  section-forms'>
<form action="altera_gerenciador.php" method="get">
    <table class='table table-hover table-responsive table-bordered'>
         <tr>
            <td>Nome</td>
            <td><input type='text' name='nome' value='<?php echo $gerenciador->getNome();?>' class='form-control' /></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type='text' name='email' value='<?php echo $gerenciador->getEmail();?>'class='form-control' /></td>
        </tr>

        <tr>
            <td>Senha</td>
            <td><input type='password' name='senha' id= 'senha' class='form-control'/></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Alterar</button>
                <a href='fornecedores.php' class='btn btn-primary left-margin'>Cancela</a>
            </td>
        </tr>
    </table>
    <input type='hidden' name='id' value='<?php echo $gerenciador->getId();?>'/>
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

if (isset($_GET['erro']) && $_GET['erro'] === 'gerenciador-ja-existente') {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Erro ao adicionar gerenciador',
            text: 'Já existe um gerenciador ou usuario cadastrado com esse email! :(',
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


