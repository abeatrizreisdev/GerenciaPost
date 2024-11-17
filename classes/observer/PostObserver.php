<?php
interface PostObserver {
    // Método de atualização que agora também recebe o tipo de evento
    public function update(Post $post, $event);
}
