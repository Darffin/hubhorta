<?php

include_once "comum.php";


//if ( is_session_started() === FALSE ) {
    session_start();

    // No caso de uma conta criada com login ativo
    if(isset($_GET["conta-criada"])) {
    session_destroy();
    header("location: login.php?conta-criada");
    exit();
    }

    if(isset($_SESSION["nome_usuario"])) {
        session_destroy();
        header("location: index.php");
        exit();
    } 
//} 
?>




		