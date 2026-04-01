<?php
$page_title = "Login";

// layout do cabeçalho
include_once "layout_header.php";
include_once "fachada.php";

$limit = 5;
$page = $_POST['page'] ?? 1;
$start = ($page - 1) * $limit;


//$dao = $factory->getHortasDAO();
//$hortas = $dao->buscaComNomePaginado('', $start, $limit);
$total_data =  5;// $dao->contaComNome('');

?>
<div class="login-conteudo">
    <div class= "container">
        <section class="login col col-md-6 p-4">
                <h1>Acessar ou criar conta</h1>
            <form action="executa_login.php" method="POST" role="form">
                <legend>Acesse sua conta</legend>

                <div class="form-group">
                <label for="login">Usuario</label>
                <input type="text" class="form-control" id="login" name="login" style="width: 50%; margin-bottom: 10px;" placeholder="Digite seu nome de usuario" autocomplete="off">
                <label for="senha">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" style="width: 50%; margin-bottom: 10px;" placeholder="Informe a senha">
                </div>
                <button type="submit" class="btn btn-primary">Entrar</button>
            </form>
        </section>
        
        <section class="col col-md-6 p-4 criar-conta">
            <h1>Crie uma conta de maneira rápida, fácil e gratuita!</h1>
            <h2>Crie sua conta de forma gratuita e tenha acesso a ferramentas para o gerenciamento e divulgação da sua horta!</h1>
            <div class="text-center pt-2"><a href="/hubhorta/usuario/novo_usuario.php"><button type="submit" class="btn btn-primary">Criar conta</button></a></div>
        </section>

        <section class="lista">
            <ul class="item-lista">
        <?php
        
        if ($total_data > 0) {
           for($i=0; $i<$total_data; $i++){// foreach ( /*$Hortas as $Horta*/) {
                echo '
                        <li class="horta-card">
                            <a href="/hubhorta/mostra_horta.php?" class="">
                                <div class="image-container" style="height: 230px;">
                                    <img src="images/uploads/"/>
                                </div>
                            </a>
                        </li>
                    ';
            }
        }
            
        ?>
            </ul>
        </section>
    </div>
</div>
<?php
if (isset($_GET['erro']) && $_GET['erro'] === 'senha') {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Erro de autenticação',
            text: 'Verifique seus dados e tente outra vez! =D',
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
            title: 'Erro de autenticação',
            text: 'Você precisa fornecer seu nome de usuario e senha para se logar!',
            scrollbarPadding: false,
            customClass: {
            popup: 'pop-up',
			confirmButton: 'btn-vermelho'
        }
        });
    </script>";
}
?>


<?php
// layout do rodapé
include_once "layout_footer.php";

?>




