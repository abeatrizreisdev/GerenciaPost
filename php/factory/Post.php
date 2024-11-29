<?php
abstract class Post {
    protected $strategy;
    protected$tipo;

    public function __construct(PostStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function setStrategy($strategy) {
        $this->strategy = $strategy;
    }
    public function getStrategy() {
        return $this->strategy;
    }

    public function settipo($tipo) {
        $this->tipo = $tipo;
    }
    public function getTipo() {
        return $this->tipo;
    }

    public function display() {
        if (!$this->strategy) {
            throw new Exception("Estratégia não definida para este post.");
        }
        return $this->strategy->display($this);
    }

    abstract public function saveToDatabase();

    abstract public function editarPost($novoTexto, $novaImagemUrl = null, $novoVideoUrl = null);

    abstract public function salvarPost();
    
    abstract public function readPost();

    abstract public function deletePost();

}
?>