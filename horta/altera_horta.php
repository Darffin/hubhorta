<?php
include_once "../fachada.php";

$id = @$_POST["id"];
$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$lat = $_POST['latitude'];
$lon = $_POST['longitude'];
$id_gerenciador = @$_POST["id_gerenciador"];


$nome_temporario=$_FILES["Arquivo"]["tmp_name"];
$dao = $factory->getHortaDao();

$horta = $dao->buscaPorId($id);

if($nome_temporario != null){
    $nome_real = $_FILES["Arquivo"]["name"];
    $nome_real = str_replace(" ", "_", $nome_real);
    // Copia o arquivo para a pasta destino
    copy($nome_temporario,"../images/uploads/$nome_real"); 
}else {
    $nome_real = $horta->getImagem();
}





if (empty($nome) || empty($descricao) || empty($lat) || empty($lon) || empty($id_gerenciador)){
    header("Location: /hubhorta/horta/modifica_horta.php?id=$id&erro=nao-preenchimento");
    exit;
}

$horta->setNome($nome);
$horta->setDescricao($descricao);
$horta->setLatitude($lat);
$horta->setLongitude($lon);
$horta->setImagem($nome_real);
$horta->setGerenciador(Gerenciador::withId($id_gerenciador));


//???
$dao->altera($horta);

header("Location: /hubhorta/mostra_horta.php?id_horta=$id&horta-alterada");
exit;

?>
