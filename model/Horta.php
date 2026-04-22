<?php
class Horta {
    
    private $id;
    private $nome;
    private $latitude;
    private $longitude;
    private $gerenciador;
    private $imagem;


    public static function withId($id)
    {
    	$instance = new self(null, null, null, null, null, null);
	    $instance->setId($id);
	    return $instance;
    }


    public function __construct($id, $nome, $latitude, $longitude, $gerenciador, $imagem)
    {
        $this->id=$id;
        $this->nome=$nome;
        $this->latitude=$latitude;
        $this->longitude=$longitude;
        $this->gerenciador=$gerenciador;
        $this->imagem=$imagem;
    }

    public function getId() { return $this->id; }
    public function setId($id) {$this->id = $id;}

    public function getNome() { return $this->nome; }
    public function setNome($nome) {$this->nome = $nome;}

    public function getLatitude() { return $this->latitude; }
    public function setLatitude($latitude) {$this->latitude = $latitude;}

    public function getLongitude() { return $this->longitude; }
    public function setLongitude($longitude) {$this->longitude = $longitude;}

    public function getGerenciador() { return $this->gerenciador; }
    public function setGerenciador($gerenciador) {$this->gerenciador = $gerenciador;}
    
    public function getImagem() { return $this->imagem; }
    public function setImagem($imagem) {$this->imagem = $imagem;}
}
?>