<?php

include "../verifica.php";
$page_title = "Novo Gerenciador";
// layout do cabeçalho
include_once "../layout_header.php";
$tela = 'gerenciadores';

 ?>
 <section class='container section-forms'>
<form action="insere_gerenciador.php" method="get">
    <table class='table table-hover table-responsive table-bordered'>
         <tr>
            <td>Nome</td>
            <td><input type='text' name='nome' class='form-control' /></td>
        </tr>
         <tr>
            <td>Email</td>
            <td><input type='text' name='email' class='form-control' /></td>
        </tr>
        <tr>
        <tr>
            <td>Senha</td>
            <td><input type='password' id='senha' name='senha' class='form-control' /></td>
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
// layout do rodapé
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

if (isset($_GET['erro']) && $_GET['erro'] === 'nao-preenchimento') {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Erro ao adicionar gerenciador',
            text: 'Você precisa preencher todos os campos para cadastrar o gerenciador!',
            customClass: {
            popup: 'pop-up',
			confirmButton: 'btn-vermelho'
        }
        });
    </script>";
}

include_once "../layout_footer.php";
?>


