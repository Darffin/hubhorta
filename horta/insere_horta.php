<?php
include_once "../fachada.php";
include_once "../verifica.php";

$nome = @$_POST["nome"];
$descricao = @$_POST["descricao"];
$latitude = @$_POST["latitude"];
$longitude = @$_POST["longitude"];
$id_gerenciador = $_SESSION["id_usuario"];
$nome_temporario=$_FILES["Arquivo"]["tmp_name"];


$nome_real = $_FILES["Arquivo"]["name"];
$nome_real = str_replace(" ", "_", $nome_real);
// Copia o arquivo para a pasta destino
copy($nome_temporario,"../images/uploads/$nome_real"); 


if (empty($nome) || empty($descricao)){
    header("Location: /hubhorta/horta/nova_horta.php?erro=nao-preenchimento");
    exit;
}

$daoGerenciador = $factory->getGerenciadorDao();
$tempGerenciador = $daoGerenciador->buscaPorId($id_gerenciador);

if ($tempGerenciador==null){
    header("Location: /hubhorta/horta/nova_horta.php?erro=nao-gerenciador");
    exit;
}



$dao = $factory->getHortaDao();
$horta = new Horta(null,$nome,$descricao,$latitude,$longitude,$id_gerenciador, $nome_real);
$horta->setGerenciador(Gerenciador::withId($id_gerenciador));


$dao->insere($horta);
header("Location: ../hortas_disponiveis.php"); 
exit;


?>

