<?php
abstract class Post {
    protected $id;
    protected $strategy;
    protected $conteudo;

    public function __construct(PostStrategy $strategy = null, $id=null) {
        $this->strategy = $strategy;
        $this->id= $id;
    }

    public function setConteudo($conteudo) {
        $this->conteudo = $conteudo;
    }

    public function getConteudo() {
        return $this->conteudo;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }
    public function setStrategy($strategy) {
        $this->strategy = $strategy;
    }
    public function getStrategy() {
        return $this->strategy;
    }
    public function display() {
        if (!$this->strategy) {
            throw new Exception("Estratégia não definida para este post.");
        }
        return $this->strategy->display($this);
    }

    abstract public function saveToDatabase();

    abstract public function updatePost();
    
    abstract public function readPost();

    abstract public function deletePost();

}
?>