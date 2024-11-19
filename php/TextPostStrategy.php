<?php
include_once './PostStrategy.php';

class TextPostStrategy implements PostStrategy {
    public function display(Post $post) {
        return "<p>" . htmlspecialchars($post->getContent()) . "</p>";
    }
}
