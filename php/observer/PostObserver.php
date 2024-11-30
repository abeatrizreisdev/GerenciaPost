<?php
interface PostObserver {
    public function update(Post $post, $event);
}