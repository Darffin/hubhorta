<?php
include_once "../fachada.php";
include_once "../verifica.php";

$nome = @$_POST["nome"];
$latitude = @$_POST["latitude"];
$longitude = @$_POST["longitude"];
$id_gerenciador = $_SESSION["id_usuario"];

$string_temp = "";


//if (empty($nome) || empty($latitude) || empty($longitude) || empty($id_gerenciador)){
//    header("Location: /hubhorta/horta/nova_horta.php?erro=nao-preenchimento");
//    exit;
//}

//if (empty($nome_temporario)){
//    header("Location: /hubhorta/horta/nova_horta.php?erro=nao-selecionou-arquivo");
//    exit;
//}


// Seleciona o nome temporário do arquivo, ganho durante o upload

// Gera um nome para o arquivo
//$nome_real=$_FILES["Arquivo"]["name"];
//$nome_real = str_replace(" ", "_", $nome_real);
// Copia o arquivo para a pasta destino
//copy($nome_temporario,"../images/uploads/$nome_real"); 
//Alterar tabela de produto 

$dao = $factory->getHortaDao();
$horta = new Horta(null,$nome,$latitude,$longitude,$id_gerenciador, $string_temp);
$horta->setGerenciador(Gerenciador::withId($id_gerenciador));


$dao->insere($horta);
header("Location: ../hortas_disponiveis.php"); 
exit;


?>

