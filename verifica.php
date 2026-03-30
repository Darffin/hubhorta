<?php 
// Inicia sessões 
include_once "comum.php";
		
//if ( is_session_started() === FALSE ) {
    session_start();
//}

if (!isset($tela)) $tela = ''; 

error_log("LOGIN");

if(!isset($_SESSION["id_usuario"]) || !isset($_SESSION["nome_usuario"])) 
{ 
    error_log("SEM USUÀRIO LOGADO - Vai para login.php");
    // Usuário não logado! Redireciona para a página de login 
    header("Location: /hubhorta/login.php"); 
    exit; 
}

if($_SESSION["permissao"] != 'admin'){

    if($tela == 'usuarios' || $tela == 'gerenciadores'){
        error_log("ACESSO NEGADO - Vai para pagina inicial.php");
        header("Location: /hubhorta/index.php"); 
    }    

    if($tela == 'Estoque' && $_SESSION["permissao"] == 'usuario'){ 
        error_log("ACESSO NEGADO - Vai para pagina inicial.php");
        header("Location: /hubhorta/index.php"); 
        exit; 
    }

}
?>