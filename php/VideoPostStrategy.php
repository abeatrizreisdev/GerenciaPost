<?php
include_once './PostStrategy.php';

class VideoPostStrategy implements PostStrategy {
    public function display(Post $post) {
        return "<video src='" . htmlspecialchars($post->getContent()) . "' controls></video>";
    }
}
