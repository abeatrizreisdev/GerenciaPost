<?php
abstract class Post {
    protected $strategy;

    public function __construct(PostStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function setStrategy(PostStrategy $strategy) {
        $this->strategy = $strategy;
    }
    public function getStrategy(): PostStrategy {
        return $this->strategy;
    }

    public function display() {
        if (!$this->strategy) {
            throw new Exception("Estratégia não definida para este post.");
        }
        return $this->strategy->display($this);
    }

    abstract public function saveToDatabase();

    abstract public function editarPost($texto, $videoUrl, $imagemUrl);
    
    abstract public function readPost($conteudo);

    abstract public function deletePost();

}
?>