<?php
class Estoque {
    
    private $id;
    private $item;
    private $quantidade;
    private $id_horta;

    public function __construct( $id, $quantidade, $id_horta, $item)
    {
        $this->id=$id;
        $this->quantidade=$quantidade;
        $this->id_horta=$id_horta;
        $this->item=$item;
    }

    public function getId() { return $this->id; }
    public function setId($id) {$this->id = $id;}

    public function getNomeItem() { return $this->item; }
    public function setNomeItem($item) {$this->item = $item;}

    public function getQuantidade() { return $this->quantidade; }
    public function setQuantidade($quantidade) {$this->quantidade = $quantidade;}

    public function getIdHorta() { return $this->id_horta; }
    public function setIdHorta($id_horta) {$this->id_horta = $id_horta;}
}
?>