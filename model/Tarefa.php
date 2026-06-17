<?php
class Tarefa {
    
    private $id;
    private $titulo;
    private $descricao;
    private $id_usuario;
    private $id_horta;
    private $status;


    public static function withId($id)
    {
    	$instance = new self(null, null, null, null, null, null);
	    $instance->setId($id);
	    return $instance;
    }


    public function __construct($id, $titulo, $descricao, $id_usuario, $id_horta, $status)
    {
        $this->id=$id;
        $this->titulo=$titulo;
        $this->descricao=$descricao;
        $this->id_usuario=$id_usuario;
        $this->id_horta=$id_horta;
        $this->status=$status;
    }

    public function getId() { return $this->id; }
    public function setId($id) {$this->id = $id;}

    public function getTitulo() { return $this->titulo; }
    public function setTitulo($titulo) {$this->titulo = $titulo;}

    public function getDescricao() { return $this->descricao; }
    public function setDescricao($descricao) {$this->descricao = $descricao;}

    public function getIdUsuario() { return $this->id_usuario; }
    public function setIdUsuario($id_usuario) {$this->id_usuario = $id_usuario;}

    public function getIdHorta() { return $this->id_horta; }
    public function setIdHorta($id_horta) {$this->id_horta = $id_horta;}

    public function getStatus() { return $this->status; }
    public function setStatus($status) {$this->status = $status;}

}
?>