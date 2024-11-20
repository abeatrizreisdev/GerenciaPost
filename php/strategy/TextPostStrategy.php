<?php
require_once __DIR__ . '/../strategy/PostStrategy.php';

class TextPostStrategy implements PostStrategy {
    public function display(Post $post) {
        return "<p>" . htmlspecialchars($post->getContent()) . "</p>";
    }
}
