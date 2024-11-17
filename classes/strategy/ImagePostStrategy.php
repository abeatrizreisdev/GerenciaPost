<?php
class ImagePostStrategy implements PostStrategy {
    public function display(Post $post) {
        return "<img src='" . htmlspecialchars($post->getContent()) . "' alt='Post Image' />";
    }
}
