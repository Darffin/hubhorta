<?php 
// Métodos de acesso ao banco de dados 
require "fachada.php"; 
 
// Inicia sessão 
session_start();

// Recupera o login 
$login = isset($_POST["login"]) ? addslashes(trim($_POST["login"])) : FALSE; 
// Recupera a senha, a criptografando em MD5 
$senha = isset($_POST["senha"]) ? md5(trim($_POST["senha"])) : FALSE; 
//$senha = isset($_POST["senha"]) ? trim($_POST["senha"]) : FALSE; 
 
// Usuário não forneceu a senha ou o login 
if(!$login || !$senha) 
{ 
    header("Location: login.php?erro=nao-preenchimento");
    exit; 
}  

$dao = $factory->getUsuarioDao();
$usuario = $dao->buscaPorLogin($login);

$problemas = FALSE;
if($usuario) {
    // Agora verifica a senha 
    if(!strcmp($senha, $usuario->getSenha())) 
    { 
        // TUDO OK! Agora, passa os dados para a sessão e redireciona o usuário 
        $_SESSION["id_usuario"]= $usuario->getId(); 
        $_SESSION["nome_usuario"] = stripslashes($usuario->getNome()); 
        $_SESSION["login"] = $usuario->getLogin(); 
        $_SESSION["permissao"]= $usuario->getPermissao(); 
        header("Location: index.php"); 
        exit; 
    } else {
        $problemas = TRUE; 
    }
} else {
    $problemas = TRUE; 
}

if($problemas==TRUE) {
    header("Location: login.php?erro=senha");
    exit;

}
?>
