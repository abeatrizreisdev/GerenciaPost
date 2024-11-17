<?php
abstract class Post {
    protected $strategy;
    protected $content;

    public function __construct(PostStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getContent() {
        return $this->content;
    }

    public function display() {
        return $this->strategy->display($this);
    }

    abstract public function saveToDatabase();
}
?>