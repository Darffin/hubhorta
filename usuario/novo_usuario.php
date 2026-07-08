<?php
$page_title = "Novo Usuário";

include_once "../layout_header.php";
 ?>
 <section class='container section-forms'>
<form action="insere_usuario.php" method="get" enctype="multipart/form-data" class="form-horta">

        <div class="campo-form">
            <label for="login">Usuário</label>
            <input type="text" name="login" id="login" class="form-control">
        </div>

        <div class="campo-form">
            <label for="senha">Sua senha</label>
            <input type="password" name="senha" id="senha" class="form-control">
        </div>

        <div class="campo-form">
            <label for="nome">Seu nome completo</label>
            <input type="text" name="nome" id="nome" class="form-control">
        </div>

        <div class="campo-form">
            <label for="permissao">Nos conte o que deseja fazer!</label>
            <select name = "permissao">
            <option value="usuario">Ser voluntario</option>
            <option value="gerenciador">Gerenciar hortas</option>
            </select>
        </div>

        <div class="acoes-form">
            <input type="reset" value="Limpar" class="btn btn-secondary">
            <button type="submit" class="btn btn-primary">Inserir</button>
        </div>

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


