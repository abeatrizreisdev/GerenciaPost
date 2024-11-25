<?php
abstract class Post {
    protected $id;
    protected $strategy;
    protected $content;

    public function __construct(PostStrategy $strategy = null, $id=null) {
        $this->strategy = $strategy;
        $this->id= $id;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getContent() {
        return $this->content;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }
    public function display() {
        return $this->strategy->display($this);
    }

    abstract public function saveToDatabase();

    abstract public function updatePost();

    abstract public function deletePost();

}
?>